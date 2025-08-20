<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsFinalSectionItemRequest;
use App\Http\Requests\UpdateAboutUsFinalSectionItemRequest;
use App\Http\Resources\AboutUsFinalSectionItemResource;
use App\Models\AboutUsFinalSection;
use App\Models\AboutUsFinalSectionItem;
use App\Services\AboutUsFinalSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsFinalSectionItemController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsFinalSectionItemResource::class;
    protected AboutUsFinalSectionItemService $aboutUsFinalSectionItemService;

    public function __construct(AboutUsFinalSectionItemService $aboutUsFinalSectionItemService)
    {
        parent::__construct('about-us-final-section-items');

        $this->aboutUsFinalSectionItemService = $aboutUsFinalSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsFinalSectionItems = $this->aboutUsFinalSectionItemService->index();

            return $this->resource::collection($aboutUsFinalSectionItems)->additional([
                'recordsTotal' => $aboutUsFinalSectionItems->total(),
                'recordsFiltered' => $aboutUsFinalSectionItems->total()
            ]);
        }

        // Get counts of items per final section
        $itemsPerSection = AboutUsFinalSectionItem::selectRaw('about_us_final_section_id, COUNT(*) as count')
            ->groupBy('about_us_final_section_id')
            ->pluck('count', 'about_us_final_section_id')
            ->toArray();

        // Get all active final sections
        $allActiveSections = AboutUsFinalSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit
        $sectionsAtLimit = array_filter($itemsPerSection, function($count) {
            return $count >= 3;
        });

        return view('dashboard.about-us.final-section-item.index', compact('itemsPerSection', 'allActiveSections', 'sectionsAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get final sections that have less than 3 items
        $itemsPerSection = AboutUsFinalSectionItem::selectRaw('about_us_final_section_id, COUNT(*) as count')
            ->groupBy('about_us_final_section_id')
            ->pluck('count', 'about_us_final_section_id')
            ->toArray();

        $availableSections = AboutUsFinalSection::where('is_active', true)
            ->whereNotIn('id', array_keys(array_filter($itemsPerSection, function($count) {
                return $count >= 3;
            })))
            ->get();

        if ($availableSections->isEmpty()) {
            return redirect()->route('dashboard.about-us-final-section-items.index')
                ->with('error', 'You cannot add more items because all about us final sections have reached the limit of 3 items.');
        }

        return view('dashboard.about-us.final-section-item.create', compact('availableSections'));
    }

    public function store(StoreAboutUsFinalSectionItemRequest $request): Response
    {
        $aboutUsFinalSectionItem = $this->aboutUsFinalSectionItemService->store($request->validated());

        return $this->success("About Us Final Section Item Created Successfully", new $this->resource($aboutUsFinalSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-final-section-items.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.final-section-item.show', [
            'aboutUsFinalSectionItem' => new $this->resource($this->aboutUsFinalSectionItemService->show($id))
        ]);
    }

    public function edit(AboutUsFinalSectionItem $aboutUsFinalSectionItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active final sections for editing
        $availableSections = AboutUsFinalSection::where('is_active', true)->get();

        return view('dashboard.about-us.final-section-item.edit', compact('aboutUsFinalSectionItem', 'availableSections'));
    }

    public function update($id, UpdateAboutUsFinalSectionItemRequest $request): Response
    {
        $aboutUsFinalSectionItem = $this->aboutUsFinalSectionItemService->update($request->validated(), $id);

        return $this->success("About Us Final Section Item Updated Successfully", new $this->resource($aboutUsFinalSectionItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsFinalSectionItemService->destroy($id);

        if ($deleted)
            return $this->success('About Us Final Section Item Deleted Successfully');
        else
            return $this->notFoundError('About Us Final Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get counts of items per final section
        $itemsPerSection = AboutUsFinalSectionItem::selectRaw('about_us_final_section_id, COUNT(*) as count')
            ->groupBy('about_us_final_section_id')
            ->pluck('count', 'about_us_final_section_id')
            ->toArray();

        // Get all active final sections
        $allActiveSections = AboutUsFinalSection::where('is_active', true)->pluck('id')->toArray();

        // Check if all sections have reached the limit
        $sectionsAtLimit = array_filter($itemsPerSection, function($count) {
            return $count >= 3;
        });

        $exists = !empty(array_diff($allActiveSections, array_keys($sectionsAtLimit)));

        if ($exists) {
            return response()->json([
                'exists' => false,
                'message' => 'You can add new items.',
                'sectionsAtLimit' => $sectionsAtLimit,
                'availableSections' => array_diff($allActiveSections, array_keys($sectionsAtLimit))
            ], 200);
        }

        return response()->json([
            'exists' => true,
            'message' => 'You cannot add more items because all about us final sections have reached the limit of 3 items.',
            'sectionsAtLimit' => $sectionsAtLimit,
            'availableSections' => []
        ], 200);
    }
}
