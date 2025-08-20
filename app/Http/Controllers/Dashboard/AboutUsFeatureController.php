<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAboutUsFeatureRequest;
use App\Http\Requests\UpdateAboutUsFeatureRequest;
use App\Http\Resources\AboutUsFeatureResource;
use App\Models\AboutUsFeature;
use App\Services\AboutUsFeatureService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class AboutUsFeatureController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = AboutUsFeatureResource::class;
    protected AboutUsFeatureService $aboutUsFeatureService;

    public function __construct(AboutUsFeatureService $aboutUsFeatureService)
    {
        parent::__construct('about-us-features');

        $this->aboutUsFeatureService = $aboutUsFeatureService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $aboutUsFeatures = $this->aboutUsFeatureService->index();

            return $this->resource::collection($aboutUsFeatures)->additional([
                'recordsTotal' => $aboutUsFeatures->total(),
                'recordsFiltered' => $aboutUsFeatures->total()
            ]);
        }

        // Check if features already exist
        $existingFeatures = AboutUsFeature::count();

        return view('dashboard.about-us.features.index', compact('existingFeatures'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if features already exist
        $existingFeatures = AboutUsFeature::count();

        if ($existingFeatures >= 2) {
            return redirect()->route('dashboard.about-us-features.index')
                ->with('error', 'You cannot add more features because you can only add 2 about us features.');
        }

        return view('dashboard.about-us.features.create');
    }

    public function store(StoreAboutUsFeatureRequest $request): Response
    {
        $aboutUsFeature = $this->aboutUsFeatureService->store($request->validated());

        return $this->success("About Us Feature Created Successfully", new $this->resource($aboutUsFeature))
            ->withHeaders(['X-Redirect' => route('dashboard.about-us-features.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.about-us.features.show', [
            'aboutUsFeature' => new $this->resource($this->aboutUsFeatureService->show($id))
        ]);
    }

    public function edit(AboutUsFeature $aboutUsFeature): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.about-us.features.edit', compact('aboutUsFeature'));
    }

    public function update($id, UpdateAboutUsFeatureRequest $request): Response
    {
        $aboutUsFeature = $this->aboutUsFeatureService->update($request->validated(), $id);

        return $this->success("About Us Feature Updated Successfully", new $this->resource($aboutUsFeature));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->aboutUsFeatureService->destroy($id);

        if ($deleted)
            return $this->success('About Us Feature Deleted Successfully');
        else
            return $this->notFoundError('About Us Feature doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if features already exist
        $existingFeatures = AboutUsFeature::count();

        if ($existingFeatures >= 2) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more features because you can only add 2 about us features.',
                'count' => $existingFeatures
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new about us feature.',
            'count' => $existingFeatures
        ], 200);
    }
}
