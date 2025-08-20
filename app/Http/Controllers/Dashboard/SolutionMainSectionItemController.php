<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionMainSectionItemRequest;
use App\Http\Requests\UpdateSolutionMainSectionItemRequest;
use App\Http\Resources\SolutionMainSectionItemResource;
use App\Models\SolutionMainSection;
use App\Models\SolutionMainSectionItem;
use App\Services\SolutionMainSectionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionMainSectionItemController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionMainSectionItemResource::class;
    protected SolutionMainSectionItemService $solutionMainSectionItemService;

    public function __construct(SolutionMainSectionItemService $solutionMainSectionItemService)
    {
        parent::__construct('solution-main-section-items');

        $this->solutionMainSectionItemService = $solutionMainSectionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionMainSectionItems = $this->solutionMainSectionItemService->index();

            return $this->resource::collection($solutionMainSectionItems)->additional([
                'recordsTotal' => $solutionMainSectionItems->count(),
                'recordsFiltered' => $solutionMainSectionItems->count()
            ]);
        }

        // Get counts of items per solution main section
        $itemsPerSection = SolutionMainSectionItem::selectRaw('solution_main_section_id, COUNT(*) as count')
            ->groupBy('solution_main_section_id')
            ->pluck('count', 'solution_main_section_id')
            ->toArray();

        // Get all active solution main sections
        $allActiveSections = SolutionMainSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit
        $sectionsAtLimit = array_filter($itemsPerSection, function($count) {
            return $count >= 3;
        });

        return view('dashboard.solutions.main-section-item.index', compact('itemsPerSection', 'allActiveSections', 'sectionsAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get solution main sections that have less than 3 items
        $itemsPerSection = SolutionMainSectionItem::selectRaw('solution_main_section_id, COUNT(*) as count')
            ->groupBy('solution_main_section_id')
            ->pluck('count', 'solution_main_section_id')
            ->toArray();

        $availableSections = SolutionMainSection::where('is_active', true)
            ->whereNotIn('id', array_keys(array_filter($itemsPerSection, function($count) {
                return $count >= 3;
            })))
            ->get();

        if ($availableSections->isEmpty()) {
            return redirect()->route('dashboard.solution-main-section-items.index')
                ->with('error', 'You cannot add more items because all solution main sections have reached the limit of 3 items.');
        }

        return view('dashboard.solutions.main-section-item.create', compact('availableSections'));
    }

    public function store(StoreSolutionMainSectionItemRequest $request): Response
    {
        $solutionMainSectionItem = $this->solutionMainSectionItemService->store($request->validated());

        return $this->success("Solution Main Section Item Created Successfully", new $this->resource($solutionMainSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-section-items.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.main-section-item.show', [
            'solutionMainSectionItem' => new $this->resource($this->solutionMainSectionItemService->show($id))
        ]);
    }

    public function edit(SolutionMainSectionItem $solutionMainSectionItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active solution main sections for editing
        $availableSections = SolutionMainSection::where('is_active', true)->get();

        return view('dashboard.solutions.main-section-item.edit', compact('solutionMainSectionItem', 'availableSections'));
    }

    public function update($id, UpdateSolutionMainSectionItemRequest $request): Response
    {
        $solutionMainSectionItem = $this->solutionMainSectionItemService->update($request->validated(), $id);

        return $this->success("Solution Main Section Item Updated Successfully", new $this->resource($solutionMainSectionItem))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-section-items.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionMainSectionItemService->destroy($id);

        if ($deleted)
            return $this->success('Solution Main Section Item Deleted Successfully');
        else
            return $this->notFoundError('Solution Main Section Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get counts of items per solution main section
        $itemsPerSection = SolutionMainSectionItem::selectRaw('solution_main_section_id, COUNT(*) as count')
            ->groupBy('solution_main_section_id')
            ->pluck('count', 'solution_main_section_id')
            ->toArray();

        // Get all active solution main sections
        $allActiveSections = SolutionMainSection::where('is_active', true)->pluck('id')->toArray();

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
            'message' => 'You cannot add more items because all solution main sections have reached the limit of 3 items.',
            'sectionsAtLimit' => $sectionsAtLimit,
            'availableSections' => []
        ], 200);
    }
}
