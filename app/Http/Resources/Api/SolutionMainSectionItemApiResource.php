<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionMainSectionItemApiResource extends JsonResource
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
            'image' => $this->image,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'solution_main_section_item_content' => new SolutionMainSectionItemContentApiResource($this->whenLoaded('solutionMainSectionItemContent')),
        ];
    }
}
