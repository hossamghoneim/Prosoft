<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contact_us_content_id' => $this->contact_us_content_id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'contact_us_content' => $this->whenLoaded('contactUsContent'),
        ];
    }
}
