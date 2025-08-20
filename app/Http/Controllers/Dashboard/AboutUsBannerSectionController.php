<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsBannerSectionRequest;
use App\Http\Requests\UpdateAboutUsBannerSectionRequest;
use App\Http\Resources\AboutUsBannerSectionResource;
use App\Models\AboutUsBannerSection;
use App\Services\AboutUsBannerSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsBannerSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsBannerSectionResource::class;
    protected AboutUsBannerSectionService $aboutUsBannerSectionService;

    public function __construct(AboutUsBannerSectionService $aboutUsBannerSectionService)
    {
        parent::__construct('about-us-banner-sections');

        $this->aboutUsBannerSectionService = $aboutUsBannerSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsBannerSections = $this->aboutUsBannerSectionService->index();

            return $this->resource::collection($aboutUsBannerSections)->additional([
                'recordsTotal' => $aboutUsBannerSections->total(),
                'recordsFiltered' => $aboutUsBannerSections->total()
            ]);
        }

        // Check if a banner section already exists
        $existingBanner = AboutUsBannerSection::first();

        return view('dashboard.about-us.banner-section.index', compact('existingBanner'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a banner section already exists
        $existingBanner = AboutUsBannerSection::first();

        if ($existingBanner) {
            return redirect()->route('dashboard.about-us-banner-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 about us banner section.');
        }

        return view('dashboard.about-us.banner-section.create');
    }

    public function store(StoreAboutUsBannerSectionRequest $request): Response
    {
        $aboutUsBannerSection = $this->aboutUsBannerSectionService->store($request->validated());

        return $this->success("About Us Banner Section Created Successfully", new $this->resource($aboutUsBannerSection))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-banner-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.banner-section.show', [
            'aboutUsBannerSection' => new $this->resource($this->aboutUsBannerSectionService->show($id))
        ]);
    }

    public function edit(AboutUsBannerSection $aboutUsBannerSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.about-us.banner-section.edit', compact('aboutUsBannerSection'));
    }

    public function update($id, UpdateAboutUsBannerSectionRequest $request): Response
    {
        $aboutUsBannerSection = $this->aboutUsBannerSectionService->update($request->validated(), $id);

        return $this->success("About Us Banner Section Updated Successfully", new $this->resource($aboutUsBannerSection))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-banner-sections.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsBannerSectionService->destroy($id);

        if ($deleted)
            return $this->success('About Us Banner Section Deleted Successfully');
        else
            return $this->notFoundError('About Us Banner Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a banner section already exists
        $existingBanner = AboutUsBannerSection::first();

        if ($existingBanner) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 about us banner section.',
                'bannerId' => $existingBanner->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new about us banner section.',
        ], 200);
    }
}
