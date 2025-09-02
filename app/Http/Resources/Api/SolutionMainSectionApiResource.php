<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionMainSectionApiResource extends JsonResource
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
            'solution_id' => $this->solution_id,
            'enable_grid_view' => $this->enable_grid_view,
            'is_active' => $this->is_active,
            'solution_main_section_items' => SolutionMainSectionItemApiResource::collection($this->whenLoaded('solutionMainSectionItems')),
        ];
    }
}
