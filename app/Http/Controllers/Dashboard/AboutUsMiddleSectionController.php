<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsMiddleSectionRequest;
use App\Http\Requests\UpdateAboutUsMiddleSectionRequest;
use App\Http\Resources\AboutUsMiddleSectionResource;
use App\Models\AboutUsMiddleSection;
use App\Services\AboutUsMiddleSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsMiddleSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsMiddleSectionResource::class;
    protected AboutUsMiddleSectionService $aboutUsMiddleSectionService;

    public function __construct(AboutUsMiddleSectionService $aboutUsMiddleSectionService)
    {
        parent::__construct('about-us-middle-sections');

        $this->aboutUsMiddleSectionService = $aboutUsMiddleSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsMiddleSections = $this->aboutUsMiddleSectionService->index();

            return $this->resource::collection($aboutUsMiddleSections)->additional([
                'recordsTotal' => $aboutUsMiddleSections->total(),
                'recordsFiltered' => $aboutUsMiddleSections->total()
            ]);
        }

        // Check if an about us middle section already exists
        $existingSection = AboutUsMiddleSection::first();

        return view('dashboard.about-us.middle-section.index', compact('existingSection'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if an about us middle section already exists
        $existingSection = AboutUsMiddleSection::first();

        if ($existingSection) {
            return redirect()->route('dashboard.about-us-middle-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 about us middle section.');
        }

        return view('dashboard.about-us.middle-section.create');
    }

    public function store(StoreAboutUsMiddleSectionRequest $request): Response
    {
        $aboutUsMiddleSection = $this->aboutUsMiddleSectionService->store($request->validated());

        return $this->success("About Us Middle Section Created Successfully", new $this->resource($aboutUsMiddleSection))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-middle-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.middle-section.show', [
            'aboutUsMiddleSection' => new $this->resource($this->aboutUsMiddleSectionService->show($id))
        ]);
    }

    public function edit(AboutUsMiddleSection $aboutUsMiddleSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.about-us.middle-section.edit', compact('aboutUsMiddleSection'));
    }

    public function update($id, UpdateAboutUsMiddleSectionRequest $request): Response
    {
        $aboutUsMiddleSection = $this->aboutUsMiddleSectionService->update($request->validated(), $id);

        return $this->success("About Us Middle Section Updated Successfully", new $this->resource($aboutUsMiddleSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsMiddleSectionService->destroy($id);

        if ($deleted)
            return $this->success('About Us Middle Section Deleted Successfully');
        else
            return $this->notFoundError('About Us Middle Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if an about us middle section already exists
        $existingSection = AboutUsMiddleSection::first();

        if ($existingSection) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 about us middle section.',
                'sectionId' => $existingSection->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new about us middle section.',
        ], 200);
    }
}
