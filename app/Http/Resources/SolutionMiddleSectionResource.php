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
            'title' => $this->title,
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
