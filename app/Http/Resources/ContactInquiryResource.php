<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInquiryResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'company' => $this->company,
            'email' => $this->email,
            'phone' => $this->phone,
            'inquiry_type' => $this->inquiry_type,
            'inquiry_type_name' => $this->inquiry_type_name,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
