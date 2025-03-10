<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
          'email' => $this->email,
          'phone' => $this->phone,
          'image' => $this->image,
          'created_at' => $this->created_at?->format('Y-m-d / h:i a'),
          'role' => $this->whenLoaded('role', fn() => new RoleResource($this->role)),
        ];
    }
}
