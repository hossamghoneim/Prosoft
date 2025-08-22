<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeSecondarySectionRequest;
use App\Http\Requests\UpdateHomeSecondarySectionRequest;
use App\Http\Resources\HomeSecondarySectionResource;
use App\Models\HomeSecondarySection;
use App\Services\HomeSecondarySectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class HomeSecondarySectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = HomeSecondarySectionResource::class;
    protected HomeSecondarySectionService $homeSecondarySectionService;

    public function __construct(HomeSecondarySectionService $homeSecondarySectionService)
    {
        parent::__construct('home-secondary-sections');

        $this->homeSecondarySectionService = $homeSecondarySectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $homeSecondarySections = $this->homeSecondarySectionService->index();

            return $this->resource::collection($homeSecondarySections)->additional([
                'recordsTotal' => $homeSecondarySections->total(),
                'recordsFiltered' => $homeSecondarySections->total()
            ]);
        }

        // Check if secondary section already exists
        $existingSecondary = HomeSecondarySection::first();

        return view('dashboard.home.secondary-section.index', compact('existingSecondary'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if secondary section already exists
        $existingSecondary = HomeSecondarySection::first();

        if ($existingSecondary) {
            return redirect()->route('dashboard.home-secondary-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 home secondary section.');
        }

        return view('dashboard.home.secondary-section.create');
    }

    public function store(StoreHomeSecondarySectionRequest $request): Response
    {
        try {
            $homeSecondarySection = $this->homeSecondarySectionService->store($request->validated());

            return $this->success("Home Secondary Section Created Successfully", new $this->resource($homeSecondarySection))
                ->withHeaders(['X-Redirect' => route('dashboard.home-secondary-sections.index')]);
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.home.secondary-section.show', [
            'homeSecondarySection' => new $this->resource($this->homeSecondarySectionService->show($id))
        ]);
    }

    public function edit(HomeSecondarySection $homeSecondarySection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.home.secondary-section.edit', compact('homeSecondarySection'));
    }

    public function update($id, UpdateHomeSecondarySectionRequest $request): Response
    {
        $homeSecondarySection = $this->homeSecondarySectionService->update($request->validated(), $id);

        return $this->success("Home Secondary Section Updated Successfully", new $this->resource($homeSecondarySection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->homeSecondarySectionService->destroy($id);

        if ($deleted)
            return $this->success('Home Secondary Section Deleted Successfully');
        else
            return $this->notFoundError('Home Secondary Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if secondary section already exists
        $existingSecondary = HomeSecondarySection::first();

        if ($existingSecondary) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 home secondary section.',
                'secondaryId' => $existingSecondary->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new home secondary section.'
        ], 200);
    }
}
