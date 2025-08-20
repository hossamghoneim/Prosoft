<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnershipSectionRequest;
use App\Http\Requests\UpdatePartnershipSectionRequest;
use App\Http\Resources\PartnershipSectionResource;
use App\Models\PartnershipSection;
use App\Services\PartnershipSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PartnershipSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = PartnershipSectionResource::class;
    protected PartnershipSectionService $partnershipSectionService;

    public function __construct(PartnershipSectionService $partnershipSectionService)
    {
        parent::__construct('partnership-sections');

        $this->partnershipSectionService = $partnershipSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $partnershipSections = $this->partnershipSectionService->index();

            return $this->resource::collection($partnershipSections)->additional([
                'recordsTotal' => $partnershipSections->total(),
                'recordsFiltered' => $partnershipSections->total()
            ]);
        }

        // Check if a partnership section already exists
        $existingSection = PartnershipSection::first();

        return view('dashboard.partnerships.section.index', compact('existingSection'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a partnership section already exists
        $existingSection = PartnershipSection::first();

        if ($existingSection) {
            return redirect()->route('dashboard.partnership-sections.index')
                ->with('error', 'You cannot add more content because you can only add 1 partnership section.');
        }

        return view('dashboard.partnerships.section.create');
    }

    public function store(StorePartnershipSectionRequest $request): Response
    {
        $partnershipSection = $this->partnershipSectionService->store($request->validated());

        return $this->success("Partnership Section Created Successfully", new $this->resource($partnershipSection))
            ->withHeaders(['X-Redirect' => route('dashboard.partnership-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.partnerships.section.show', [
            'partnershipSection' => new $this->resource($this->partnershipSectionService->show($id))
        ]);
    }

    public function edit(PartnershipSection $partnershipSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.partnerships.section.edit', compact('partnershipSection'));
    }

    public function update($id, UpdatePartnershipSectionRequest $request): Response
    {
        $partnershipSection = $this->partnershipSectionService->update($request->validated(), $id);

        return $this->success("Partnership Section Updated Successfully", new $this->resource($partnershipSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->partnershipSectionService->destroy($id);

        if ($deleted)
            return $this->success('Partnership Section Deleted Successfully');
        else
            return $this->notFoundError('Partnership Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a partnership section already exists
        $existingSection = PartnershipSection::first();

        if ($existingSection) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 partnership section.',
                'sectionId' => $existingSection->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new partnership section.',
        ], 200);
    }
}
