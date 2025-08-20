<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use App\Models\PartnershipSection;
use App\Services\PartnerService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PartnerController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = PartnerResource::class;
    protected PartnerService $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        parent::__construct('partners');

        $this->partnerService = $partnerService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $partners = $this->partnerService->index();

            return $this->resource::collection($partners)->additional([
                'recordsTotal' => $partners->total(),
                'recordsFiltered' => $partners->total()
            ]);
        }

        // Get counts of partners per partnership section
        $partnersPerSection = Partner::selectRaw('partnership_section_id, COUNT(*) as count')
            ->groupBy('partnership_section_id')
            ->pluck('count', 'partnership_section_id')
            ->toArray();

        // Get all active partnership sections
        $allActiveSections = PartnershipSection::where('is_active', true)->pluck('id')->toArray();

        // Get sections that have reached the limit
        $sectionsAtLimit = array_filter($partnersPerSection, function($count) {
            return $count >= 6;
        });

        return view('dashboard.partners.index', compact('partnersPerSection', 'allActiveSections', 'sectionsAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get partnership sections that have less than 6 partners
        $partnersPerSection = Partner::selectRaw('partnership_section_id, COUNT(*) as count')
            ->groupBy('partnership_section_id')
            ->pluck('count', 'partnership_section_id')
            ->toArray();

        $availableSections = PartnershipSection::where('is_active', true)
            ->whereNotIn('id', array_keys(array_filter($partnersPerSection, function($count) {
                return $count >= 6;
            })))
            ->get();

        if ($availableSections->isEmpty()) {
            return redirect()->route('dashboard.partners.index')
                ->with('error', 'You cannot add more partners because all partnership sections have reached the limit of 6 partners.');
        }

        return view('dashboard.partners.create', compact('availableSections'));
    }

    public function store(StorePartnerRequest $request): Response
    {
        $partner = $this->partnerService->store($request->validated());

        return $this->success("Partner Created Successfully", new $this->resource($partner))
            ->withHeaders(['X-Redirect' => route('dashboard.partners.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.partners.show', [
            'partner' => new $this->resource($this->partnerService->show($id))
        ]);
    }

    public function edit(Partner $partner): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all active partnership sections for editing
        $availableSections = PartnershipSection::where('is_active', true)->get();

        return view('dashboard.partners.edit', compact('partner', 'availableSections'));
    }

    public function update($id, UpdatePartnerRequest $request): Response
    {
        $partner = $this->partnerService->update($request->validated(), $id);

        return $this->success("Partner Updated Successfully", new $this->resource($partner));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->partnerService->destroy($id);

        if ($deleted)
            return $this->success('Partner Deleted Successfully');
        else
            return $this->notFoundError('Partner doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get counts of partners per partnership section
        $partnersPerSection = Partner::selectRaw('partnership_section_id, COUNT(*) as count')
            ->groupBy('partnership_section_id')
            ->pluck('count', 'partnership_section_id')
            ->toArray();

        // Get all active partnership sections
        $allActiveSections = PartnershipSection::where('is_active', true)->pluck('id')->toArray();

        // Check if all sections have reached the limit
        $sectionsAtLimit = array_filter($partnersPerSection, function($count) {
            return $count >= 6;
        });

        $exists = !empty(array_diff($allActiveSections, array_keys($sectionsAtLimit)));

        if ($exists) {
            return response()->json([
                'exists' => false,
                'message' => 'You can add new partners.',
                'sectionsAtLimit' => $sectionsAtLimit,
                'availableSections' => array_diff($allActiveSections, array_keys($sectionsAtLimit))
            ], 200);
        }

        return response()->json([
            'exists' => true,
            'message' => 'You cannot add more partners because all partnership sections have reached the limit of 6 partners.',
            'sectionsAtLimit' => $sectionsAtLimit,
            'availableSections' => []
        ], 200);
    }
}
