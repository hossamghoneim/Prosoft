<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionMainSectionRequest;
use App\Http\Requests\UpdateSolutionMainSectionRequest;
use App\Http\Resources\SolutionMainSectionResource;
use App\Models\Solution;
use App\Models\SolutionMainSection;
use App\Services\SolutionMainSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionMainSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionMainSectionResource::class;
    protected SolutionMainSectionService $solutionMainSectionService;

    public function __construct(SolutionMainSectionService $solutionMainSectionService)
    {
        parent::__construct('solution-main-sections');

        $this->solutionMainSectionService = $solutionMainSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionMainSections = $this->solutionMainSectionService->index();

            return $this->resource::collection($solutionMainSections)->additional([
                'recordsTotal' => $solutionMainSections->count(),
                'recordsFiltered' => $solutionMainSections->count()
            ]);
        }

        return view('dashboard.solutions.main-section.index');
    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active solutions
        $solutions = Solution::where('is_active', true)->get();

        return view('dashboard.solutions.main-section.create', compact('solutions'));
    }

    public function store(StoreSolutionMainSectionRequest $request): Response
    {
        $solutionMainSection = $this->solutionMainSectionService->store($request->validated());

        return $this->success("Solution Main Section Created Successfully", new $this->resource($solutionMainSection))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.main-section.show', [
            'solutionMainSection' => new $this->resource($this->solutionMainSectionService->show($id))
        ]);
    }

    public function edit(SolutionMainSection $solutionMainSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active solutions
        $solutions = Solution::where('is_active', true)->get();

        return view('dashboard.solutions.main-section.edit', compact('solutionMainSection', 'solutions'));
    }

    public function update($id, UpdateSolutionMainSectionRequest $request): Response
    {
        $solutionMainSection = $this->solutionMainSectionService->update($request->validated(), $id);

        return $this->success("Solution Main Section Updated Successfully", new $this->resource($solutionMainSection))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-sections.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionMainSectionService->destroy($id);

        if ($deleted)
            return $this->success('Solution Main Section Deleted Successfully');
        else
            return $this->notFoundError('Solution Main Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // This method is no longer needed since we removed global limitation
        // Keeping it for backward compatibility but it always returns false
        return response()->json([
            'exists' => false,
            'message' => 'You can add a new solution main section.',
        ], 200);
    }
}
