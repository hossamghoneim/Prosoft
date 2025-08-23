<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermsConditionHeroSectionResource extends JsonResource
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
            'description' => $this->description,
            'video_url' => $this->video_url,
            'is_active' => $this->is_active,
            'effective_date' => $this->effective_date,
            'created_at' => $this->created_at,
        ];
    }
}
