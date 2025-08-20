<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'partnership_section_id' => $this->partnership_section_id,
            'title' => $this->title,
            'description' => $this->description,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'background_color' => $this->background_color,
            'inner_logo' => $this->inner_logo,
            'outer_logo' => $this->outer_logo,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'partnership_section' => $this->whenLoaded('partnershipSection'),
        ];
    }
}
