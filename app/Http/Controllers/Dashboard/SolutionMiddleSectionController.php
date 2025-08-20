<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionMiddleSectionRequest;
use App\Http\Requests\UpdateSolutionMiddleSectionRequest;
use App\Http\Resources\SolutionMiddleSectionResource;
use App\Models\SolutionMiddleSection;
use App\Services\SolutionMiddleSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionMiddleSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionMiddleSectionResource::class;
    protected SolutionMiddleSectionService $solutionMiddleSectionService;

    public function __construct(SolutionMiddleSectionService $solutionMiddleSectionService)
    {
        parent::__construct('solution-middle-sections');

        $this->solutionMiddleSectionService = $solutionMiddleSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionMiddleSections = $this->solutionMiddleSectionService->index();

            return $this->resource::collection($solutionMiddleSections)->additional([
                'recordsTotal' => $solutionMiddleSections->total(),
                'recordsFiltered' => $solutionMiddleSections->total()
            ]);
        }

        return view('dashboard.solutions.middle-section.index');
    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active solutions
        $solutions = \App\Models\Solution::where('is_active', true)->get();

        return view('dashboard.solutions.middle-section.create', compact('solutions'));
    }

    public function store(StoreSolutionMiddleSectionRequest $request): Response
    {
        $solutionMiddleSection = $this->solutionMiddleSectionService->create($request->validated());

        return $this->success("Solution Middle Section Created Successfully", new $this->resource($solutionMiddleSection))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-middle-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        $solutionMiddleSection = $this->solutionMiddleSectionService->find($id);

        return view('dashboard.solutions.middle-section.show', compact('solutionMiddleSection'));
    }

    public function edit(SolutionMiddleSection $solutionMiddleSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active solutions
        $solutions = \App\Models\Solution::where('is_active', true)->get();

        return view('dashboard.solutions.middle-section.edit', compact('solutionMiddleSection', 'solutions'));
    }

    public function update($id, UpdateSolutionMiddleSectionRequest $request): Response
    {
        $solutionMiddleSection = $this->solutionMiddleSectionService->update($id, $request->validated());

        return $this->success("Solution Middle Section Updated Successfully", new $this->resource($solutionMiddleSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionMiddleSectionService->delete($id);

        if ($deleted)
            return $this->success('Solution Middle Section Deleted Successfully');
        else
            return $this->notFoundError('Solution Middle Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // This method is no longer needed since we removed global limitation
        // Keeping it for backward compatibility but it always returns false
        return response()->json([
            'exists' => false,
            'message' => 'You can add a new solution middle section.',
        ], 200);
    }
}
