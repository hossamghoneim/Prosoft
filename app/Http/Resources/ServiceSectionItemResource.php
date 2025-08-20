<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSectionItemResource extends JsonResource
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
            'service_section_id' => $this->service_section_id,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'service_section' => $this->whenLoaded('serviceSection'),
        ];
    }
}
