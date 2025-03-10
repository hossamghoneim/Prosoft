<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Requests\StoreCarModelRequest;
use App\Http\Requests\UpdateCarModelRequest;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use App\Services\BrandService;
use App\Services\CarModelService;
use App\Traits\HttpResponsesTrait;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CarModelController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = CarModelResource::class;
    protected CarModelService $carModelService;
    protected BrandService $brandService;

    public function __construct(CarModelService $carModelService, BrandService $brandService)
    {
        parent::__construct('car-models');
        $this->carModelService = $carModelService;
        $this->brandService = $brandService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);
        $brands = $this->brandService->index();

        if (request()->ajax()){
            $carModels = $this->carModelService->index();
            return $this->resource::collection( $carModels )->additional([
                'recordsTotal' => $carModels->total(),
                'recordsFiltered' => $carModels->total()
            ]);
        }

        return view('dashboard.car_models.index',['brands' => $brands]);

    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);
        $brands = $this->brandService->index();

        return view('dashboard.car_models.create', [ 'brands' => $brands ]);
    }

    public function edit(CarModel $carModel): View
    {
        $this->authorize(PermissionActions::CREATE);
        $brands = $this->brandService->index();

        return view('dashboard.car_models.edit',compact( 'carModel', 'brands'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.car_models.show', [
            'carModel' => new $this->resource($this->carModelService->show($id))
        ]);
    }
    public function store(StoreCarModelRequest $request): Response
    {
        $carModel = $this->carModelService->store($request->validated());
        return $this->success("Car Model Created Successfully", new $this->resource($carModel));
    }
    public function update($id, UpdateCarModelRequest $request): Response
    {
        $carModel = $this->carModelService->update($request->validated(), $id);
        return $this->success("Car Model Updated Successfully", new $this->resource($carModel));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);
        $deleted = $this->carModelService->destroy($id);

        if ( $deleted )
            return $this->success('Car Model Deleted Successfully');
        else
            return $this->notFoundError('Car Model doesn\'t exist');
    }
}
