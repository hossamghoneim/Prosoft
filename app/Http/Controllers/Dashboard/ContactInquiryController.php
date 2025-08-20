<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PermissionActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactInquiryRequest;
use App\Http\Resources\ContactInquiryResource;
use App\Models\ContactInquiry;
use App\Services\ContactInquiryService;
use App\Traits\HttpResponsesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ContactInquiryController extends Controller
{
    use HttpResponsesTrait;

    private string $resource = ContactInquiryResource::class;
    protected ContactInquiryService $contactInquiryService;

    public function __construct(ContactInquiryService $contactInquiryService)
    {
        parent::__construct('contact-inquiries');

        $this->contactInquiryService = $contactInquiryService;
    }

    public function index(): View|AnonymousResourceCollection
    {
        $this->authorize(PermissionActions::LIST_VIEW);

        if (request()->ajax()) {
            $contactInquiries = $this->contactInquiryService->index();

            return $this->resource::collection($contactInquiries)->additional([
                'recordsTotal' => $contactInquiries->total(),
                'recordsFiltered' => $contactInquiries->total()
            ]);
        }

        return view('dashboard.contact-inquiries.index');
    }

    public function store(StoreContactInquiryRequest $request): Response
    {
        $contactInquiry = $this->contactInquiryService->store($request->validated());

        return $this->success("Contact Inquiry Created Successfully", new $this->resource($contactInquiry))
            ->withHeaders(['X-Redirect' => route('dashboard.contact-inquiries.index')]);
    }

    public function show($id): View
    {
        $this->authorize(PermissionActions::DETAILED_VIEW);

        return view('dashboard.contact-inquiries.show', [
            'contactInquiry' => new $this->resource($this->contactInquiryService->show($id))
        ]);
    }

    public function destroy($id): Response
    {
        $this->authorize(PermissionActions::DELETE);

        $deleted = $this->contactInquiryService->destroy($id);

        if ($deleted)
            return $this->success('Contact Inquiry Deleted Successfully');
        else
            return $this->notFoundError('Contact Inquiry doesn\'t exist');
    }
}
