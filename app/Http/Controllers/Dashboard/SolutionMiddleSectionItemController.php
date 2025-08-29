<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionMiddleSectionItemRequest;
use App\Http\Requests\UpdateSolutionMiddleSectionItemRequest;
use App\Http\Resources\SolutionMiddleSectionItemResource;
use App\Models\SolutionMiddleSection;
use App\Models\SolutionMiddleSectionItem;
use App\Services\SolutionMiddleSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionMiddleSectionItemController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionMiddleSectionItemResource::class;
    protected SolutionMiddleSectionItemService $solutionMiddleSectionItemService;

    public function __construct(SolutionMiddleSectionItemService $solutionMiddleSectionItemService)
    {
        parent::__construct('solution-middle-section-items');

        $this->solutionMiddleSectionItemService = $solutionMiddleSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionMiddleSectionItems = $this->solutionMiddleSectionItemService->index();

            return $this->resource::collection($solutionMiddleSectionItems)->additional([
                'recordsTotal' => $solutionMiddleSectionItems->total(),
                'recordsFiltered' => $solutionMiddleSectionItems->total()
            ]);
        }

        // Get counts of items per middle section
        $itemsPerSection = SolutionMiddleSectionItem::selectRaw('solution_middle_section_id, COUNT(*) as count')
            ->groupBy('solution_middle_section_id')
            ->pluck('count', 'solution_middle_section_id')
            ->toArray();

        // Get all active middle sections
        $allActiveSections = SolutionMiddleSection::where('is_active', true)->pluck('id')->toArray();

        return view('dashboard.solutions.middle-section-item.index', compact('itemsPerSection', 'allActiveSections'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get all active middle sections
        $availableSections = SolutionMiddleSection::where('is_active', true)->get();

        return view('dashboard.solutions.middle-section-item.create', compact('availableSections'));
    }

    public function store(StoreSolutionMiddleSectionItemRequest $request): Response
    {
        $solutionMiddleSectionItem = $this->solutionMiddleSectionItemService->store($request->validated());

        return $this->success("Solution Middle Section Item Created Successfully", new $this->resource($solutionMiddleSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-middle-section-items.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.middle-section-item.show', [
            'solutionMiddleSectionItem' => new $this->resource($this->solutionMiddleSectionItemService->show($id))
        ]);
    }

    public function edit(SolutionMiddleSectionItem $solutionMiddleSectionItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active middle sections for editing
        $availableSections = SolutionMiddleSection::where('is_active', true)->get();

        return view('dashboard.solutions.middle-section-item.edit', compact('solutionMiddleSectionItem', 'availableSections'));
    }

    public function update($id, UpdateSolutionMiddleSectionItemRequest $request): Response
    {
        $solutionMiddleSectionItem = $this->solutionMiddleSectionItemService->update($request->validated(), $id);

        return $this->success("Solution Middle Section Item Updated Successfully", new $this->resource($solutionMiddleSectionItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionMiddleSectionItemService->destroy($id);

        if ($deleted)
            return $this->success('Solution Middle Section Item Deleted Successfully');
        else
            return $this->notFoundError('Solution Middle Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get all active middle sections
        $allActiveSections = SolutionMiddleSection::where('is_active', true)->pluck('id')->toArray();

        return response()->json([
            'exists' => false,
            'message' => 'You can add new items.',
            'availableSections' => $allActiveSections
        ], 200);
    }
}
