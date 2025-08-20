<?php

namespace App\Services;

use App\Interfaces\ContactUsContentRepositoryInterface;
use App\Models\ContactUsContent;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactUsContentService
{
    protected ContactUsContentRepositoryInterface $contactUsContentRepository;

    public function __construct(ContactUsContentRepositoryInterface $contactUsContentRepository)
    {
        $this->contactUsContentRepository = $contactUsContentRepository;
    }

    public function index($noLimit = false): LengthAwarePaginator
    {
        return $this->contactUsContentRepository->index($noLimit);
    }

    public function show($id)
    {
        return $this->contactUsContentRepository->show($id);
    }

    public function store(array $attributes)
    {
        // Handle video upload
        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = upload_file($attributes['video_url'], 'contact-us-videos');
        }

        return $this->contactUsContentRepository->store($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $contactUsContent = $this->contactUsContentRepository->show($id);

        // Handle video update
        if (isset($attributes['video_url'])) {
            $attributes['video_url'] = update_file($contactUsContent->video_url, $attributes['video_url'], 'contact-us-videos');
        }

        return $this->contactUsContentRepository->update($id, $attributes);
    }

    public function destroy(int $id): int
    {
        return $this->contactUsContentRepository->destroy($id);
    }
}
