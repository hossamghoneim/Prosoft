<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionMiddleSectionResource extends JsonResource
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
            'solution_id' => $this->solution_id,
            'main_title' => $this->main_title,
            'first_card_icon' => $this->first_card_icon,
            'first_card_title' => $this->first_card_title,
            'first_card_description' => $this->first_card_description,
            'second_card_icon' => $this->second_card_icon,
            'second_card_title' => $this->second_card_title,
            'second_card_description' => $this->second_card_description,
            'third_card_icon' => $this->third_card_icon,
            'third_card_title' => $this->third_card_title,
            'third_card_description' => $this->third_card_description,
            'is_active' => $this->is_active,
            'solution' => $this->whenLoaded('solution', function () {
                return [
                    'id' => $this->solution->id,
                    'title' => $this->solution->title,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
