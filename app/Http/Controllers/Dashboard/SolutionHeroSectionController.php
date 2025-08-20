<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionHeroSectionRequest;
use App\Http\Requests\UpdateSolutionHeroSectionRequest;
use App\Http\Resources\SolutionHeroSectionResource;
use App\Models\Solution;
use App\Models\SolutionHeroSection;
use App\Services\SolutionHeroSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionHeroSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionHeroSectionResource::class;
    protected SolutionHeroSectionService $solutionHeroSectionService;

    public function __construct(SolutionHeroSectionService $solutionHeroSectionService)
    {
        parent::__construct('solution-hero-sections');

        $this->solutionHeroSectionService = $solutionHeroSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionHeroSections = $this->solutionHeroSectionService->index();

            return $this->resource::collection($solutionHeroSections)->additional([
                'recordsTotal' => $solutionHeroSections->total(),
                'recordsFiltered' => $solutionHeroSections->total()
            ]);
        }

        return view('dashboard.solutions.hero-section.index');
    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active solutions
        $solutions = Solution::where('is_active', true)->get();

        return view('dashboard.solutions.hero-section.create', compact('solutions'));
    }

    public function store(StoreSolutionHeroSectionRequest $request): Response
    {
        $solutionHeroSection = $this->solutionHeroSectionService->store($request->validated());

        return $this->success("Solution Hero Section Created Successfully", new $this->resource($solutionHeroSection))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-hero-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.hero-section.show', [
            'solutionHeroSection' => new $this->resource($this->solutionHeroSectionService->show($id))
        ]);
    }

    public function edit(SolutionHeroSection $solutionHeroSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active solutions
        $solutions = Solution::where('is_active', true)->get();

        return view('dashboard.solutions.hero-section.edit', compact('solutionHeroSection', 'solutions'));
    }

    public function update($id, UpdateSolutionHeroSectionRequest $request): Response
    {
        $solutionHeroSection = $this->solutionHeroSectionService->update($request->validated(), $id);

        return $this->success("Solution Hero Section Updated Successfully", new $this->resource($solutionHeroSection))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-hero-sections.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionHeroSectionService->destroy($id);

        if ($deleted)
            return $this->success('Solution Hero Section Deleted Successfully');
        else
            return $this->notFoundError('Solution Hero Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // This method is no longer needed since we removed global limitation
        // Keeping it for backward compatibility but it always returns false
        return response()->json([
            'exists' => false,
            'message' => 'You can add a new solution hero section.',
        ], 200);
    }
}
