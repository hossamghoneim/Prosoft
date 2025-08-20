<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerBannerSectionItemResource extends JsonResource
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
            'partner_banner_section_id' => $this->partner_banner_section_id,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'partner_banner_section' => $this->whenLoaded('partnerBannerSection'),
        ];
    }
}
