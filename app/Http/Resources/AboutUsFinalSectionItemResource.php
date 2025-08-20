<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsFinalSectionItemResource extends JsonResource
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
            'about_us_final_section_id' => $this->about_us_final_section_id,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'about_us_final_section' => $this->whenLoaded('aboutUsFinalSection'),
        ];
    }
}
