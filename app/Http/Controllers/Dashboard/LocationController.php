<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use App\Services\LocationService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class LocationController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = LocationResource::class;
    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        parent::__construct('locations');

        $this->locationService = $locationService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $locations = $this->locationService->index();

            return $this->resource::collection($locations)->additional([
                'recordsTotal' => $locations->total(),
                'recordsFiltered' => $locations->total()
            ]);
        }

        // Check if locations already exist
        $existingLocations = Location::count();

        return view('dashboard.locations.index', compact('existingLocations'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if locations already exist
        $existingLocations = Location::count();

        if ($existingLocations >= 2) {
            return redirect()->route('dashboard.locations.index')
                ->with('error', 'You cannot add more locations because you can only add 2 locations.');
        }

        return view('dashboard.locations.create');
    }

    public function store(StoreLocationRequest $request): Response
    {
        $location = $this->locationService->store($request->validated());

        return $this->success("Location Created Successfully", new $this->resource($location))
            ->withHeaders(['X-Redirect' => route('dashboard.locations.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.locations.show', [
            'location' => new $this->resource($this->locationService->show($id))
        ]);
    }

    public function edit(Location $location): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.locations.edit', compact('location'));
    }

    public function update($id, UpdateLocationRequest $request): Response
    {
        $location = $this->locationService->update($request->validated(), $id);

        return $this->success("Location Updated Successfully", new $this->resource($location));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->locationService->destroy($id);

        if ($deleted)
            return $this->success('Location Deleted Successfully');
        else
            return $this->notFoundError('Location doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if locations already exist
        $existingLocations = Location::count();

        if ($existingLocations >= 2) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more locations because you can only add 2 locations.',
                'count' => $existingLocations
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new location.',
            'count' => $existingLocations
        ], 200);
    }
}
