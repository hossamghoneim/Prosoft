<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
          'name' => $this->name,
          'name_ar' => $this->name_ar,
          'name_en' => $this->name_en,
          'permissions' => $this->permissions,
          'is_system_role' => $this->is_system_role,
        ];
    }
}
