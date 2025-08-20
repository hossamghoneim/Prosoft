<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsFeatureItemResource extends JsonResource
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
            'about_us_feature_id' => $this->about_us_feature_id,
            'icon' => $this->icon,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'about_us_feature' => $this->whenLoaded('aboutUsFeature'),
        ];
    }
}
