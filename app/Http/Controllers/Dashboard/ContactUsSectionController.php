<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsSectionRequest;
use App\Http\Requests\UpdateContactUsSectionRequest;
use App\Http\Resources\ContactUsSectionResource;
use App\Models\ContactUsContent;
use App\Models\ContactUsSection;
use App\Services\ContactUsSectionService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ContactUsSectionController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = ContactUsSectionResource::class;
    protected ContactUsSectionService $contactUsSectionService;

    public function __construct(ContactUsSectionService $contactUsSectionService)
    {
        parent::__construct('contact-us-sections');

        $this->contactUsSectionService = $contactUsSectionService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $contactUsSections = $this->contactUsSectionService->index();

            return $this->resource::collection($contactUsSections)->additional([
                'recordsTotal' => $contactUsSections->total(),
                'recordsFiltered' => $contactUsSections->total()
            ]);
        }

        // Get counts of sections per contact us content
        $sectionsPerContent = ContactUsSection::selectRaw('contact_us_content_id, COUNT(*) as count')
            ->groupBy('contact_us_content_id')
            ->pluck('count', 'contact_us_content_id')
            ->toArray();

        // Get all contact us contents
        $allContactUsContents = ContactUsContent::pluck('id')->toArray();

        // Get contents that have reached the limit
        $contentsAtLimit = array_filter($sectionsPerContent, function($count) {
            return $count >= 3;
        });

        return view('dashboard.contact-us.section.index', compact('sectionsPerContent', 'allContactUsContents', 'contentsAtLimit'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Get counts of sections per contact us content
        $sectionsPerContent = ContactUsSection::selectRaw('contact_us_content_id, COUNT(*) as count')
            ->groupBy('contact_us_content_id')
            ->pluck('count', 'contact_us_content_id')
            ->toArray();

        // Get all contact us contents
        $allContactUsContents = ContactUsContent::pluck('id')->toArray();

        // Filter to only show contents that have less than 3 sections
        $availableContents = ContactUsContent::whereNotIn('id', array_keys(array_filter($sectionsPerContent, function($count) {
            return $count >= 3;
        })))
        ->get();

        // If all contents are at the limit, redirect with error
        if ($availableContents->isEmpty()) {
            return redirect()->route('dashboard.contact-us-sections.index')
                ->with('error', 'You cannot add more sections because all contact us contents have reached the limit of 3 sections.');
        }

        return view('dashboard.contact-us.section.create', compact('availableContents'));
    }

    public function store(StoreContactUsSectionRequest $request): Response
    {
        $contactUsSection = $this->contactUsSectionService->store($request->validated());

        return $this->success("Contact Us Section Created Successfully", new $this->resource($contactUsSection))
            ->withHeaders(['X-Redirect' => route('dashboard.contact-us-sections.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.contact-us.section.show', [
            'contactUsSection' => new $this->resource($this->contactUsSectionService->show($id))
        ]);
    }

    public function edit(ContactUsSection $contactUsSection): View
    {
        $this->authorize(PermissionActions::UPDATE);

        // Get all contact us contents for the dropdown
        $availableContents = ContactUsContent::all();

        return view('dashboard.contact-us.section.edit', compact('contactUsSection', 'availableContents'));
    }

    public function update($id, UpdateContactUsSectionRequest $request): Response
    {
        $contactUsSection = $this->contactUsSectionService->update($request->validated(), $id);

        return $this->success("Contact Us Section Updated Successfully", new $this->resource($contactUsSection));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->contactUsSectionService->destroy($id);

        if ($deleted)
            return $this->success('Contact Us Section Deleted Successfully');
        else
            return $this->notFoundError('Contact Us Section doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Get counts of sections per contact us content
        $sectionsPerContent = ContactUsSection::selectRaw('contact_us_content_id, COUNT(*) as count')
            ->groupBy('contact_us_content_id')
            ->pluck('count', 'contact_us_content_id')
            ->toArray();

        // Get all contact us contents
        $allContactUsContents = ContactUsContent::pluck('id')->toArray();

        // Get contents that have reached the limit
        $contentsAtLimit = array_filter($sectionsPerContent, function($count) {
            return $count >= 3;
        });

        // Check if ALL contact us contents have reached the limit
        $availableContents = array_diff($allContactUsContents, array_keys($contentsAtLimit));
        $allContentsAtLimit = empty($availableContents);

        if ($allContentsAtLimit) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more sections because all contact us contents have reached the limit of 3 sections.',
                'contentsAtLimit' => $contentsAtLimit,
                'availableContents' => []
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add new sections to available contact us contents.',
            'contentsAtLimit' => $contentsAtLimit,
            'availableContents' => $availableContents
        ], 200);
    }
}
