<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomePrimarySectionRequest;
use App\Http\Requests\UpdateHomePrimarySectionRequest;
use App\Http\Resources\HomePrimarySectionResource;
use App\Models\HomePrimarySection;
use App\Services\HomePrimarySectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class HomePrimarySectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = HomePrimarySectionResource::class;
    protected HomePrimarySectionService $homePrimarySectionService;

    public function __construct(HomePrimarySectionService $homePrimarySectionService)
    {
        parent::__construct('home-primary-sections');

        $this->homePrimarySectionService = $homePrimarySectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $homePrimarySections = $this->homePrimarySectionService->index();

            return $this->resource::collection($homePrimarySections)->additional([
                'recordsTotal' => $homePrimarySections->total(),
                'recordsFiltered' => $homePrimarySections->total()
            ]);
        }

        // Check if primary section already exists
        $existingPrimary = HomePrimarySection::first();

        return view('dashboard.home.primary-section.index', compact('existingPrimary'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if primary section already exists
        $existingPrimary = HomePrimarySection::first();

        if ($existingPrimary) {
            return redirect()->route('dashboard.home-primary-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 home primary section.');
        }

        return view('dashboard.home.primary-section.create');
    }

    public function store(StoreHomePrimarySectionRequest $request): Response
    {
        $homePrimarySection = $this->homePrimarySectionService->store($request->validated());

        return $this->success("Home Primary Section Created Successfully", new $this->resource($homePrimarySection))
            ->withHeaders(['X-Redirect' => route('dashboard.home-primary-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.home.primary-section.show', [
            'homePrimarySection' => new $this->resource($this->homePrimarySectionService->show($id))
        ]);
    }

    public function edit(HomePrimarySection $homePrimarySection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.home.primary-section.edit', compact('homePrimarySection'));
    }

    public function update($id, UpdateHomePrimarySectionRequest $request): Response
    {
        $homePrimarySection = $this->homePrimarySectionService->update($request->validated(), $id);

        return $this->success("Home Primary Section Updated Successfully", new $this->resource($homePrimarySection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->homePrimarySectionService->destroy($id);

        if ($deleted)
            return $this->success('Home Primary Section Deleted Successfully');
        else
            return $this->notFoundError('Home Primary Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if primary section already exists
        $existingPrimary = HomePrimarySection::first();

        if ($existingPrimary) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 home primary section.',
                'primaryId' => $existingPrimary->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new home primary section.'
        ], 200);
    }
}
