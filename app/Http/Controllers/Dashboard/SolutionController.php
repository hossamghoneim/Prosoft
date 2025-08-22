<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolutionRequest;
use App\Http\Requests\UpdateSolutionRequest;
use App\Http\Resources\SolutionResource;
use App\Models\Solution;
use App\Services\SolutionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SolutionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = SolutionResource::class;
    protected SolutionService $solutionService;

    public function __construct(SolutionService $solutionService)
    {
        parent::__construct('solutions');

        $this->solutionService = $solutionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $solutions = $this->solutionService->index();

            return $this->resource::collection($solutions)->additional([
                'recordsTotal' => $solutions->total(),
                'recordsFiltered' => $solutions->total()
            ]);
        }

        return view('dashboard.solutions.index');
    }

    public function create(): View
    {
        $this->authorize(PermissionActions::CREATE);

        return view('dashboard.solutions.create');
    }

    public function store(StoreSolutionRequest $request): Response
    {
        $solution = $this->solutionService->store($request->validated());

        return $this->success("Solution Created Successfully", new $this->resource($solution))
            ->withHeaders(['X-Redirect' => route('dashboard.solutions.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.solutions.show', [
            'solution' => new $this->resource($this->solutionService->show($id))
        ]);
    }

    public function edit(Solution $solution): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.solutions.edit', compact('solution'));
    }

    public function update($id, UpdateSolutionRequest $request): Response
    {
        $solution = $this->solutionService->update($request->validated(), $id);

        return $this->success("Solution Updated Successfully", new $this->resource($solution))
            ->withHeaders(['X-Redirect' => route('dashboard.solutions.index')]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->solutionService->destroy($id);

        if ($deleted)
            return $this->success('Solution Deleted Successfully');
        else
            return $this->notFoundError('Solution doesn\'t exist');
    }
}

