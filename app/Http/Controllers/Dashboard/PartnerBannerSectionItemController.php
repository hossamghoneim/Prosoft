<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerBannerSectionItemRequest;
use App\Http\Requests\UpdatePartnerBannerSectionItemRequest;
use App\Http\Resources\PartnerBannerSectionItemResource;
use App\Models\PartnerBannerSection;
use App\Models\PartnerBannerSectionItem;
use App\Services\PartnerBannerSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PartnerBannerSectionItemController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = PartnerBannerSectionItemResource::class;
    protected PartnerBannerSectionItemService $partnerBannerSectionItemService;

    public function __construct(PartnerBannerSectionItemService $partnerBannerSectionItemService)
    {
        parent::__construct('partner-banner-section-items');

        $this->partnerBannerSectionItemService = $partnerBannerSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $partnerBannerSectionItems = $this->partnerBannerSectionItemService->index();

            return $this->resource::collection($partnerBannerSectionItems)->additional([
                'recordsTotal' => $partnerBannerSectionItems->total(),
                'recordsFiltered' => $partnerBannerSectionItems->total()
            ]);
        }

        // Get counts of items per partner banner section
        $itemsPerSection = PartnerBannerSectionItem::selectRaw('partner_banner_section_id, COUNT(*) as count')
            ->groupBy('partner_banner_section_id')
            ->pluck('count', 'partner_banner_section_id')
            ->toArray();

        // Get all active partner banner sections
        $allActiveSections = PartnerBannerSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit
        $sectionsAtLimit = array_filter($itemsPerSection, function($count) {
            return $count >= 3;
        });

        return view('dashboard.partners.banner-section-item.index', compact('itemsPerSection', 'allActiveSections', 'sectionsAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get counts of items per partner banner section
        $itemsPerSection = PartnerBannerSectionItem::selectRaw('partner_banner_section_id, COUNT(*) as count')
            ->groupBy('partner_banner_section_id')
            ->pluck('count', 'partner_banner_section_id')
            ->toArray();

        // Get all active partner banner sections
        $allActiveSections = PartnerBannerSection::where('is_active', true)->pluck('id')->toArray();

        // Filter to only show sections that have less than 3 items
        $availableSections = PartnerBannerSection::where('is_active', true)
            ->whereNotIn('id', array_keys(array_filter($itemsPerSection, function($count) {
                return $count >= 3;
            })))
            ->get();

        // If all sections are at the limit, redirect with error
        if ($availableSections->isEmpty()) {
            return redirect()->route('dashboard.partner-banner-section-items.index')
                ->with('error', 'You cannot add more items because all partner banner sections have reached the limit of 3 items.');
        }

        return view('dashboard.partners.banner-section-item.create', compact('availableSections'));
    }

    public function store(StorePartnerBannerSectionItemRequest $request): Response
    {
        $partnerBannerSectionItem = $this->partnerBannerSectionItemService->store($request->validated());

        return $this->success("Partner Banner Section Item Created Successfully", new $this->resource($partnerBannerSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.partner-banner-section-items.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.partners.banner-section-item.show', [
            'partnerBannerSectionItem' => new $this->resource($this->partnerBannerSectionItemService->show($id))
        ]);
    }

    public function edit(PartnerBannerSectionItem $partnerBannerSectionItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active partner banner sections for the dropdown
        $availableSections = PartnerBannerSection::where('is_active', true)->get();

        return view('dashboard.partners.banner-section-item.edit', compact('partnerBannerSectionItem', 'availableSections'));
    }

    public function update($id, UpdatePartnerBannerSectionItemRequest $request): Response
    {
        $partnerBannerSectionItem = $this->partnerBannerSectionItemService->update($request->validated(), $id);

        return $this->success("Partner Banner Section Item Updated Successfully", new $this->resource($partnerBannerSectionItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->partnerBannerSectionItemService->destroy($id);

        if ($deleted)
            return $this->success('Partner Banner Section Item Deleted Successfully');
        else
            return $this->notFoundError('Partner Banner Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get counts of items per partner banner section
        $itemsPerSection = PartnerBannerSectionItem::selectRaw('partner_banner_section_id, COUNT(*) as count')
            ->groupBy('partner_banner_section_id')
            ->pluck('count', 'partner_banner_section_id')
            ->toArray();

        // Get all active partner banner sections
        $allActiveSections = PartnerBannerSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit
        $sectionsAtLimit = array_filter($itemsPerSection, function($count) {
            return $count >= 3;
        });

        // Check if ALL active sections have reached the limit
        $availableSections = array_diff($allActiveSections, array_keys($sectionsAtLimit));
        $allSectionsAtLimit = empty($availableSections);

        if ($allSectionsAtLimit) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more items because all partner banner sections have reached the limit of 3 items.',
                'sectionsAtLimit' => $sectionsAtLimit,
                'availableSections' => []
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add new items to available partner banner sections.',
            'sectionsAtLimit' => $sectionsAtLimit,
            'availableSections' => $availableSections
        ], 200);
    }
}
