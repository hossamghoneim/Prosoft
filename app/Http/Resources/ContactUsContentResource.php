<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsContentResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'created_at' => $this->created_at,
        ];
    }
}
