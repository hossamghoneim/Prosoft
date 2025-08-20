<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceSectionItemRequest;
use App\Http\Requests\UpdateServiceSectionItemRequest;
use App\Http\Resources\ServiceSectionItemResource;
use App\Models\ServiceSectionItem;
use App\Models\ServiceSection;
use App\Services\ServiceSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ServiceSectionItemController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = ServiceSectionItemResource::class;
    protected ServiceSectionItemService $serviceSectionItemService;

    public function __construct(ServiceSectionItemService $serviceSectionItemService)
    {
        parent::__construct('service-section-items');

        $this->serviceSectionItemService = $serviceSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $serviceSectionItems = $this->serviceSectionItemService->index();

            return $this->resource::collection( $serviceSectionItems )->additional([
                'recordsTotal' => $serviceSectionItems->total(),
                'recordsFiltered' => $serviceSectionItems->total()
            ]);
        }

        // Get count of existing items for each service section
        $existingItems = ServiceSectionItem::selectRaw('service_section_id, COUNT(*) as count')
            ->groupBy('service_section_id')
            ->pluck('count', 'service_section_id')
            ->toArray();

        return view('dashboard.services.section-item.index', compact('existingItems'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active service sections
        $allActiveSections = ServiceSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit of 3 items
        $serviceSectionsWithItems = ServiceSectionItem::selectRaw('service_section_id, COUNT(*) as count')
            ->groupBy('service_section_id')
            ->having('count', '>=', 3)
            ->pluck('service_section_id')
            ->toArray();

        // Get sections that haven't reached the limit
        $availableSections = ServiceSection::where('is_active', true)
            ->whereNotIn('id', $serviceSectionsWithItems)
            ->get();

        // Check if ALL service sections have reached the limit
        if (empty(array_diff($allActiveSections, $serviceSectionsWithItems))) {
            return redirect()->route('dashboard.service-section-items.index')
                ->with('error', 'All service sections have reached the maximum limit of 3 items. You cannot add more items.');
        }

        return view('dashboard.services.section-item.create', compact('availableSections'));
    }

    public function edit(ServiceSectionItem $serviceSectionItem): View
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active service sections (including the current one for editing)
        $availableSections = ServiceSection::where('is_active', true)->get();

        return view('dashboard.services.section-item.edit',compact( 'serviceSectionItem', 'availableSections'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.services.section-item.show', [
            'serviceSectionItem' => new $this->resource($this->serviceSectionItemService->show($id))
        ]);
    }

    public function store(StoreServiceSectionItemRequest $request): Response
    {
        $serviceSectionItem = $this->serviceSectionItemService->store($request->validated());

        return $this->success("Service Section Item Created Successfully", new $this->resource($serviceSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.service-section-items.index')]);
    }
    public function update($id, UpdateServiceSectionItemRequest $request): Response
    {
        $serviceSectionItem = $this->serviceSectionItemService->update($request->validated(), $id);

        return $this->success("Service Section Item Updated Successfully", new $this->resource($serviceSectionItem));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->serviceSectionItemService->destroy($id);

        if ( $deleted )
            return $this->success('Service Section Item Deleted Successfully');
        else
            return $this->notFoundError('Service Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get all active service sections
        $allActiveSections = ServiceSection::where('is_active', true)->pluck('id')->toArray();

        // Get count of existing items for each service section
        $existingItems = ServiceSectionItem::selectRaw('service_section_id, COUNT(*) as count')
            ->groupBy('service_section_id')
            ->pluck('count', 'service_section_id')
            ->toArray();

        // Get sections that have reached the limit of 3 items
        $sectionsAtLimit = array_filter($existingItems, function($count) {
            return $count >= 3;
        });

        // Check if ALL service sections have reached the limit
        $allSectionsAtLimit = empty(array_diff($allActiveSections, array_keys($sectionsAtLimit)));

        if ($allSectionsAtLimit) {
            return response()->json([
                'exists' => true,
                'message' => 'All service sections have reached the maximum limit of 3 items. You cannot add more items.',
                'sectionsAtLimit' => array_keys($sectionsAtLimit)
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add new items to available service sections.',
            'availableSections' => $existingItems,
            'sectionsAtLimit' => array_keys($sectionsAtLimit)
        ], 200);
    }
}
