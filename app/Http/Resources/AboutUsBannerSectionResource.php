<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsBannerSectionResource extends JsonResource
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
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'video_url' => $this->video_url,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}
