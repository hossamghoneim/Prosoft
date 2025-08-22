<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSecondarySectionResource extends JsonResource
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
            'main_title' => $this->main_title,
            'main_description' => $this->main_description,
            'background_image' => $this->background_image,
            'first_card_logo' => $this->first_card_logo,
            'first_card_title' => $this->first_card_title,
            'first_card_description' => $this->first_card_description,
            'second_card_logo' => $this->second_card_logo,
            'second_card_title' => $this->second_card_title,
            'second_card_description' => $this->second_card_description,
            'third_card_logo' => $this->third_card_logo,
            'third_card_title' => $this->third_card_title,
            'third_card_description' => $this->third_card_description,
            'created_at' => $this->created_at,
        ];
    }
}
