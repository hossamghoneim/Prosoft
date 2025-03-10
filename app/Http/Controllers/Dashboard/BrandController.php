<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BrandController extends Controller
{
    use HttpResponsesTrait;
    private string $resource = BrandResource::class;
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        parent::__construct('brands');
        $this->brandService = $brandService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()){
            $brands = $this->brandService->index();
            return $this->resource::collection( $brands )->additional([
                'recordsTotal' => $brands->total(),
                'recordsFiltered' => $brands->total()
            ]);
        }

        return view('dashboard.brands.index');

    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.brands.create');
    }

    public function edit(Brand $brand): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.brands.edit',compact( 'brand'));
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.brands.show', [
            'brand' => new $this->resource($this->brandService->show($id))
        ]);
    }
    public function store(StoreBrandRequest $request): Response
    {
        $brand = $this->brandService->store($request->validated());
        return $this->success("Brand Created Successfully", new $this->resource($brand));
    }
    public function update($id, UpdateBrandRequest $request): Response
    {
        $brand = $this->brandService->update($request->validated(), $id);
        return $this->success("Brand Updated Successfully", new $this->resource($brand));
    }
    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);
        $deleted = $this->brandService->destroy($id);

        if ( $deleted )
            return $this->success('Brand Deleted Successfully');
        else
            return $this->notFoundError('Brand doesn\'t exist');
    }
}
