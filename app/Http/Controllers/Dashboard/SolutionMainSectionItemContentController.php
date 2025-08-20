<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionMainSectionItemContentRequest;
use App\Http\Requests\UpdateSolutionMainSectionItemContentRequest;
use App\Http\Resources\SolutionMainSectionItemContentResource;
use App\Models\SolutionMainSectionItem;
use App\Models\SolutionMainSectionItemContent;
use App\Services\SolutionMainSectionItemContentService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class SolutionMainSectionItemContentController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionMainSectionItemContentResource::class;
    protected SolutionMainSectionItemContentService $solutionMainSectionItemContentService;

    public function __construct(SolutionMainSectionItemContentService $solutionMainSectionItemContentService)
    {
        parent::__construct('solution-main-section-item-contents');

        $this->solutionMainSectionItemContentService = $solutionMainSectionItemContentService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutionMainSectionItemContents = $this->solutionMainSectionItemContentService->index();

            return $this->resource::collection($solutionMainSectionItemContents)->additional([
                'recordsTotal' => $solutionMainSectionItemContents->count(),
                'recordsFiltered' => $solutionMainSectionItemContents->count()
            ]);
        }

        // Check if any solution main section items exist
        $existingItems = SolutionMainSectionItem::where('is_active', true)->get();

        return view('dashboard.solutions.main-section-item-content.index', compact('existingItems'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get solution main section items that don't have content yet
        $itemsWithContent = SolutionMainSectionItemContent::pluck('solution_main_section_item_id')->toArray();

        $items = SolutionMainSectionItem::where('is_active', true)
            ->whereNotIn('id', $itemsWithContent)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('dashboard.solution-main-section-item-contents.index')
                ->with('error', 'You cannot add more content because all solution main section items already have content.');
        }

        return view('dashboard.solutions.main-section-item-content.create', compact('items'));
    }

    public function store(StoreSolutionMainSectionItemContentRequest $request): Response
    {
        $solutionMainSectionItemContent = $this->solutionMainSectionItemContentService->store($request->validated());

        return $this->success("Solution Main Section Item Content Created Successfully", new $this->resource($solutionMainSectionItemContent))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-section-item-contents.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.main-section-item-content.show', [
            'solutionMainSectionItemContent' => new $this->resource($this->solutionMainSectionItemContentService->show($id))
        ]);
    }

    public function edit(SolutionMainSectionItemContent $content): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active solution main section items for editing
        $availableItems = SolutionMainSectionItem::where('is_active', true)->get();

        return view('dashboard.solutions.main-section-item-content.edit', compact('content', 'availableItems'));
    }

    public function update($id, UpdateSolutionMainSectionItemContentRequest $request): Response
    {
        $solutionMainSectionItemContent = $this->solutionMainSectionItemContentService->update($request->validated(), $id);

        return $this->success("Solution Main Section Item Content Updated Successfully", new $this->resource($solutionMainSectionItemContent))
            ->withHeaders(['X-Redirect' => route('dashboard.solution-main-section-item-contents.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionMainSectionItemContentService->destroy($id);

        if ($deleted)
            return $this->success('Solution Main Section Item Content Deleted Successfully');
        else
            return $this->notFoundError('Solution Main Section Item Content doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if any solution main section items exist
        $existingItems = SolutionMainSectionItem::where('is_active', true)->get();

        if ($existingItems->isEmpty()) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add content because no solution main section items exist.',
                'availableItems' => []
            ], 200);
        }

        // Get solution main section items that don't have content yet
        $itemsWithContent = SolutionMainSectionItemContent::pluck('solution_main_section_item_id')->toArray();

        $availableItems = $existingItems->whereNotIn('id', $itemsWithContent);

        if ($availableItems->isEmpty()) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because all solution main section items already have content.',
                'availableItems' => []
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add new content.',
            'availableItems' => $availableItems->pluck('id')->toArray()
        ], 200);
    }
}
