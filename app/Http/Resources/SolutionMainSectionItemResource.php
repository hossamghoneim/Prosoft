<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionMainSectionItemResource extends JsonResource
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
            'solution_main_section_id' => $this->solution_main_section_id,
            'title' => $this->title,
            'image' => $this->image,
            'order' => $this->order,
            'solution_main_section' => $this->whenLoaded('solutionMainSection', function () {
                return [
                    'id' => $this->solutionMainSection->id,
                    'title' => $this->solutionMainSection->title,
                ];
            }),
            'solution_main_section_item_content' => $this->whenLoaded('solutionMainSectionItemContent', function () {
                return [
                    'id' => $this->solutionMainSectionItemContent->id,
                    'title' => $this->solutionMainSectionItemContent->title,
                ];
            }),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
