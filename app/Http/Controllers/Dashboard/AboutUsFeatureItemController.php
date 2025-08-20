<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsFeatureItemRequest;
use App\Http\Requests\UpdateAboutUsFeatureItemRequest;
use App\Http\Resources\AboutUsFeatureItemResource;
use App\Models\AboutUsFeatureItem;
use App\Models\AboutUsFeature;
use App\Services\AboutUsFeatureItemService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsFeatureItemController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = AboutUsFeatureItemResource::class;
    protected AboutUsFeatureItemService $aboutUsFeatureItemService;

    public function __construct(AboutUsFeatureItemService $aboutUsFeatureItemService)
    {
        parent::__construct('about-us-feature-items');

        $this->aboutUsFeatureItemService = $aboutUsFeatureItemService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $aboutUsFeatureItems = $this->aboutUsFeatureItemService->index();

            return $this->resource::collection( $aboutUsFeatureItems )->additional([
                'recordsTotal' => $aboutUsFeatureItems->total(),
                'recordsFiltered' => $aboutUsFeatureItems->total()
            ]);
        }

        $itemsPerFeature = AboutUsFeatureItem::selectRaw('about_us_feature_id, COUNT(*) as count')->groupBy('about_us_feature_id')->pluck('count', 'about_us_feature_id')->toArray();
        $allAboutUsFeatures = AboutUsFeature::pluck('id')->toArray();
        $featuresAtLimit = array_filter($itemsPerFeature, function($count) { return $count >= 2; });

        return view('dashboard.about-us.feature-items.index', compact('itemsPerFeature', 'allAboutUsFeatures', 'featuresAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        $itemsPerFeature = AboutUsFeatureItem::selectRaw('about_us_feature_id, COUNT(*) as count')->groupBy('about_us_feature_id')->pluck('count', 'about_us_feature_id')->toArray();
        $availableFeatures = AboutUsFeature::whereNotIn('id', array_keys(array_filter($itemsPerFeature, function($count) { return $count >= 2; })))->get();

        if ($availableFeatures->isEmpty()) {
            return redirect()->route('dashboard.about-us-feature-items.index')->with('error', 'You cannot add more items because all About Us Features have reached the limit of 2 items.');
        }

        return view('dashboard.about-us.feature-items.create', compact('availableFeatures'));
    }

    public function edit(AboutUsFeatureItem $aboutUsFeatureItem): View
    {
        $this->authorize(PermissionActions::UPDATE);

        $itemsPerFeature = AboutUsFeatureItem::selectRaw('about_us_feature_id, COUNT(*) as count')->groupBy('about_us_feature_id')->pluck('count', 'about_us_feature_id')->toArray();
        $availableFeatures = AboutUsFeature::whereNotIn('id', array_keys(array_filter($itemsPerFeature, function($count) { return $count >= 2; })))->get();

        return view('dashboard.about-us.feature-items.edit', compact('aboutUsFeatureItem', 'availableFeatures'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.feature-items.show', [
            'aboutUsFeatureItem' => new $this->resource($this->aboutUsFeatureItemService->show($id))
        ]);
    }

    public function store(StoreAboutUsFeatureItemRequest $request): Response
    {
        $aboutUsFeatureItem = $this->aboutUsFeatureItemService->store($request->validated());

        return $this->success("About Us Feature Item Created Successfully", new $this->resource($aboutUsFeatureItem))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-feature-items.index')]);
    }

    public function update($id, UpdateAboutUsFeatureItemRequest $request): Response
    {
        $aboutUsFeatureItem = $this->aboutUsFeatureItemService->update($request->validated(), $id);

        return $this->success("About Us Feature Item Updated Successfully", new $this->resource($aboutUsFeatureItem));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsFeatureItemService->destroy($id);

        if ( $deleted )
            return $this->success('About Us Feature Item Deleted Successfully');
        else
            return $this->notFoundError('About Us Feature Item doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        $itemsPerFeature = AboutUsFeatureItem::selectRaw('about_us_feature_id, COUNT(*) as count')->groupBy('about_us_feature_id')->pluck('count', 'about_us_feature_id')->toArray();
        $allAboutUsFeatures = AboutUsFeature::pluck('id')->toArray();
        $featuresAtLimit = array_filter($itemsPerFeature, function($count) { return $count >= 2; });
        $availableFeatures = array_diff($allAboutUsFeatures, array_keys($featuresAtLimit));
        $allFeaturesAtLimit = empty($availableFeatures);

        if ($allFeaturesAtLimit) {
            return response()->json(['exists' => true, 'message' => 'You cannot add more items because all About Us Features have reached the limit of 2 items.', 'featuresAtLimit' => $featuresAtLimit, 'availableFeatures' => []], 200);
        }

        return response()->json(['exists' => false, 'message' => 'You can add new items to available About Us Features.', 'featuresAtLimit' => $featuresAtLimit, 'availableFeatures' => $availableFeatures], 200);
    }
}
