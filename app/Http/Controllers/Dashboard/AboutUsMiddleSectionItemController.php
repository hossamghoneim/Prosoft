<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsMiddleSectionItemRequest;
use App\Http\Requests\UpdateAboutUsMiddleSectionItemRequest;
use App\Http\Resources\AboutUsMiddleSectionItemResource;
use App\Models\AboutUsMiddleSection;
use App\Models\AboutUsMiddleSectionItem;
use App\Services\AboutUsMiddleSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsMiddleSectionItemController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsMiddleSectionItemResource::class;
    protected AboutUsMiddleSectionItemService $aboutUsMiddleSectionItemService;

    public function __construct(AboutUsMiddleSectionItemService $aboutUsMiddleSectionItemService)
    {
        parent::__construct('about-us-middle-section-items');

        $this->aboutUsMiddleSectionItemService = $aboutUsMiddleSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsMiddleSectionItems = $this->aboutUsMiddleSectionItemService->index();

            return $this->resource::collection($aboutUsMiddleSectionItems)->additional([
                'recordsTotal' => $aboutUsMiddleSectionItems->total(),
                'recordsFiltered' => $aboutUsMiddleSectionItems->total()
            ]);
        }

        // Get counts of items per middle section
        $itemsPerSection = AboutUsMiddleSectionItem::selectRaw('about_us_middle_section_id, COUNT(*) as count')
            ->groupBy('about_us_middle_section_id')
            ->pluck('count', 'about_us_middle_section_id')
            ->toArray();

        // Get all active middle sections
        $allActiveSections = AboutUsMiddleSection::where('is_active', true)->pluck('id')->toArray();

        return view('dashboard.about-us.middle-section-item.index', compact('itemsPerSection', 'allActiveSections'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active middle sections
        $availableSections = AboutUsMiddleSection::where('is_active', true)->get();

        return view('dashboard.about-us.middle-section-item.create', compact('availableSections'));
    }

    public function store(StoreAboutUsMiddleSectionItemRequest $request): Response
    {
        $aboutUsMiddleSectionItem = $this->aboutUsMiddleSectionItemService->store($request->validated());

        return $this->success("About Us Middle Section Item Created Successfully", new $this->resource($aboutUsMiddleSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-middle-section-items.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.middle-section-item.show', [
            'aboutUsMiddleSectionItem' => new $this->resource($this->aboutUsMiddleSectionItemService->show($id))
        ]);
    }

    public function edit(AboutUsMiddleSectionItem $aboutUsMiddleSectionItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active middle sections for editing
        $availableSections = AboutUsMiddleSection::where('is_active', true)->get();

        return view('dashboard.about-us.middle-section-item.edit', compact('aboutUsMiddleSectionItem', 'availableSections'));
    }

    public function update($id, UpdateAboutUsMiddleSectionItemRequest $request): Response
    {
        $aboutUsMiddleSectionItem = $this->aboutUsMiddleSectionItemService->update($request->validated(), $id);

        return $this->success("About Us Middle Section Item Updated Successfully", new $this->resource($aboutUsMiddleSectionItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsMiddleSectionItemService->destroy($id);

        if ($deleted)
            return $this->success('About Us Middle Section Item Deleted Successfully');
        else
            return $this->notFoundError('About Us Middle Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get all active middle sections
        $allActiveSections = AboutUsMiddleSection::where('is_active', true)->pluck('id')->toArray();

        return response()->json([
            'exists' => false,
            'message' => 'You can add new items.',
            'availableSections' => $allActiveSections
        ], 200);
    }
}
