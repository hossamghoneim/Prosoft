<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTermsConditionItemRequest;
use App\Http\Requests\UpdateTermsConditionItemRequest;
use App\Http\Resources\TermsConditionItemResource;
use App\Models\TermsConditionItem;
use App\Services\TermsConditionItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class TermsConditionItemController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = TermsConditionItemResource::class;
    protected TermsConditionItemService $termsConditionItemService;

    public function __construct(TermsConditionItemService $termsConditionItemService)
    {
        parent::__construct('terms-condition-items');

        $this->termsConditionItemService = $termsConditionItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $termsConditionItems = $this->termsConditionItemService->index();

            return $this->resource::collection( $termsConditionItems )->additional([
                'recordsTotal' => $termsConditionItems->total(),
                'recordsFiltered' => $termsConditionItems->total()
            ]);
        }

        // Check if we've reached the limit of 9 items
        $itemsCount = TermsConditionItem::count();

        return view('dashboard.terms-condition.items.index', compact('itemsCount'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if we've reached the limit of 9 items
        $itemsCount = TermsConditionItem::count();

        if ($itemsCount >= 9) {
            return redirect()->route('dashboard.terms-condition-items.index')
                ->with('error', 'You cannot add more content because you can only add 9 terms condition items.');
        }

        return view('dashboard.terms-condition.items.create');
    }

    public function edit(TermsConditionItem $termsConditionItem): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.terms-condition.items.edit',compact( 'termsConditionItem'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.terms-condition.items.show', [
            'termsConditionItem' => new $this->resource($this->termsConditionItemService->show($id))
        ]);
    }

    public function store(StoreTermsConditionItemRequest $request): Response
    {
        $termsConditionItem = $this->termsConditionItemService->store($request->validated());

        return $this->success("Terms Condition Item Created Successfully", new $this->resource($termsConditionItem));
    }

    public function update($id, UpdateTermsConditionItemRequest $request): Response
    {
        $termsConditionItem = $this->termsConditionItemService->update($request->validated(), $id);

        return $this->success("Terms Condition Item Updated Successfully", new $this->resource($termsConditionItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->termsConditionItemService->destroy($id);

        if ( $deleted )
            return $this->success('Terms Condition Item Deleted Successfully');
        else
            return $this->notFoundError('Terms Condition Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if we've reached the limit of 9 items
        $itemsCount = TermsConditionItem::count();

        if ($itemsCount >= 9) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 9 terms condition items.',
                'itemsCount' => $itemsCount
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new terms condition item.',
            'itemsCount' => $itemsCount
        ], 200);
    }
}

