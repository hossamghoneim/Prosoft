<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsFinalSectionRequest;
use App\Http\Requests\UpdateAboutUsFinalSectionRequest;
use App\Http\Resources\AboutUsFinalSectionResource;
use App\Models\AboutUsFinalSection;
use App\Services\AboutUsFinalSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsFinalSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsFinalSectionResource::class;
    protected AboutUsFinalSectionService $aboutUsFinalSectionService;

    public function __construct(AboutUsFinalSectionService $aboutUsFinalSectionService)
    {
        parent::__construct('about-us-final-sections');

        $this->aboutUsFinalSectionService = $aboutUsFinalSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsFinalSections = $this->aboutUsFinalSectionService->index();

            return $this->resource::collection($aboutUsFinalSections)->additional([
                'recordsTotal' => $aboutUsFinalSections->total(),
                'recordsFiltered' => $aboutUsFinalSections->total()
            ]);
        }

        // Check if a final section already exists
        $existingSection = AboutUsFinalSection::first();

        return view('dashboard.about-us.final-section.index', compact('existingSection'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a final section already exists
        $existingSection = AboutUsFinalSection::first();

        if ($existingSection) {
            return redirect()->route('dashboard.about-us-final-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 about us final section.');
        }

        return view('dashboard.about-us.final-section.create');
    }

    public function store(StoreAboutUsFinalSectionRequest $request): Response
    {
        $aboutUsFinalSection = $this->aboutUsFinalSectionService->store($request->validated());

        return $this->success("About Us Final Section Created Successfully", new $this->resource($aboutUsFinalSection))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-final-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.final-section.show', [
            'aboutUsFinalSection' => new $this->resource($this->aboutUsFinalSectionService->show($id))
        ]);
    }

    public function edit(AboutUsFinalSection $aboutUsFinalSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.about-us.final-section.edit', compact('aboutUsFinalSection'));
    }

    public function update($id, UpdateAboutUsFinalSectionRequest $request): Response
    {
        $aboutUsFinalSection = $this->aboutUsFinalSectionService->update($request->validated(), $id);

        return $this->success("About Us Final Section Updated Successfully", new $this->resource($aboutUsFinalSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsFinalSectionService->destroy($id);

        if ($deleted)
            return $this->success('About Us Final Section Deleted Successfully');
        else
            return $this->notFoundError('About Us Final Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a final section already exists
        $existingSection = AboutUsFinalSection::first();

        if ($existingSection) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 about us final section.',
                'sectionId' => $existingSection->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new about us final section.',
        ], 200);
    }
}
