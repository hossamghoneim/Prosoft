<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionMainSectionItemContentApiResource extends JsonResource
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
            'solution_main_section_item_id' => $this->solution_main_section_item_id,
            'main_title' => $this->main_title,
            'description' => $this->description,
            'background_image' => $this->background_image,
            'first_card_title' => $this->first_card_title,
            'first_card_description' => $this->first_card_description,
            'second_card_title' => $this->second_card_title,
            'second_card_description' => $this->second_card_description,
            'third_card_title' => $this->third_card_title,
            'third_card_description' => $this->third_card_description,
            'logo' => $this->logo && str_contains($this->logo, 'default.jpg') ? null : $this->logo,
        ];
    }
}
