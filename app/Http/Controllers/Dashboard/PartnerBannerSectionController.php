<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerBannerSectionRequest;
use App\Http\Requests\UpdatePartnerBannerSectionRequest;
use App\Http\Resources\PartnerBannerSectionResource;
use App\Models\PartnerBannerSection;
use App\Services\PartnerBannerSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PartnerBannerSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = PartnerBannerSectionResource::class;
    protected PartnerBannerSectionService $partnerBannerSectionService;

    public function __construct(PartnerBannerSectionService $partnerBannerSectionService)
    {
        parent::__construct('partner-banner-sections');

        $this->partnerBannerSectionService = $partnerBannerSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $partnerBannerSections = $this->partnerBannerSectionService->index();

            return $this->resource::collection($partnerBannerSections)->additional([
                'recordsTotal' => $partnerBannerSections->total(),
                'recordsFiltered' => $partnerBannerSections->total()
            ]);
        }

        // Check if a partner banner section already exists
        $existingBanner = PartnerBannerSection::first();

        return view('dashboard.partners.banner-section.index', compact('existingBanner'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a partner banner section already exists
        $existingBanner = PartnerBannerSection::first();

        if ($existingBanner) {
            return redirect()->route('dashboard.partner-banner-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 partner banner section.');
        }

        return view('dashboard.partners.banner-section.create');
    }

    public function store(StorePartnerBannerSectionRequest $request): Response
    {
        $partnerBannerSection = $this->partnerBannerSectionService->store($request->validated());

        return $this->success("Partner Banner Section Created Successfully", new $this->resource($partnerBannerSection))
            ->withHeaders(['X-Redirect' => route('dashboard.partner-banner-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.partners.banner-section.show', [
            'partnerBannerSection' => new $this->resource($this->partnerBannerSectionService->show($id))
        ]);
    }

    public function edit(PartnerBannerSection $partnerBannerSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.partners.banner-section.edit', compact('partnerBannerSection'));
    }

    public function update($id, UpdatePartnerBannerSectionRequest $request): Response
    {
        $partnerBannerSection = $this->partnerBannerSectionService->update($request->validated(), $id);

        return $this->success("Partner Banner Section Updated Successfully", new $this->resource($partnerBannerSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->partnerBannerSectionService->destroy($id);

        if ($deleted)
            return $this->success('Partner Banner Section Deleted Successfully');
        else
            return $this->notFoundError('Partner Banner Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a partner banner section already exists
        $existingBanner = PartnerBannerSection::first();

        if ($existingBanner) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 partner banner section.',
                'bannerId' => $existingBanner->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new partner banner section.',
        ], 200);
    }
}
