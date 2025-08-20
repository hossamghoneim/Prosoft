<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsContentRequest;
use App\Http\Requests\UpdateContactUsContentRequest;
use App\Http\Resources\ContactUsContentResource;
use App\Models\ContactUsContent;
use App\Services\ContactUsContentService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class ContactUsContentController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = ContactUsContentResource::class;
    protected ContactUsContentService $contactUsContentService;

    public function __construct(ContactUsContentService $contactUsContentService)
    {
        parent::__construct('contact-us-contents');

        $this->contactUsContentService = $contactUsContentService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $contactUsContents = $this->contactUsContentService->index();

            return $this->resource::collection($contactUsContents)->additional([
                'recordsTotal' => $contactUsContents->total(),
                'recordsFiltered' => $contactUsContents->total()
            ]);
        }

        // Check if a contact us content already exists
        $existingContent = ContactUsContent::first();

        return view('dashboard.contact-us.content.index', compact('existingContent'));
    }

    public function create(): View|RedirectResponse
    {
        $this->authorize(PermissionActions::CREATE);

        // Check if a contact us content already exists
        $existingContent = ContactUsContent::first();

        if ($existingContent) {
            return redirect()->route('dashboard.contact-us-contents.index')
                ->with('error', 'You cannot add more content because you can only add 1 contact us content.');
        }

        return view('dashboard.contact-us.content.create');
    }

    public function store(StoreContactUsContentRequest $request): Response
    {
        $contactUsContent = $this->contactUsContentService->store($request->validated());

        return $this->success("Contact Us Content Created Successfully", new $this->resource($contactUsContent))
            ->withHeaders(['X-Redirect' => route('dashboard.contact-us-contents.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.contact-us.content.show', [
            'contactUsContent' => new $this->resource($this->contactUsContentService->show($id))
        ]);
    }

    public function edit(ContactUsContent $contactUsContent): View
    {
        $this->authorize(PermissionActions::UPDATE);

        return view('dashboard.contact-us.content.edit', compact('contactUsContent'));
    }

    public function update($id, UpdateContactUsContentRequest $request): Response
    {
        $contactUsContent = $this->contactUsContentService->update($request->validated(), $id);

        return $this->success("Contact Us Content Updated Successfully", new $this->resource($contactUsContent));
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->contactUsContentService->destroy($id);

        if ($deleted)
            return $this->success('Contact Us Content Deleted Successfully');
        else
            return $this->notFoundError('Contact Us Content doesn\'t exist');
    }

    public function checkExists(): \Illuminate\Http\JsonResponse
    {
        // Check if a contact us content already exists
        $existingContent = ContactUsContent::first();

        if ($existingContent) {
            return response()->json([
                'exists' => true,
                'message' => 'You cannot add more content because you can only add 1 contact us content.',
                'contentId' => $existingContent->id
            ], 200);
        }

        return response()->json([
            'exists' => false,
            'message' => 'You can add a new contact us content.',
        ], 200);
    }
}
