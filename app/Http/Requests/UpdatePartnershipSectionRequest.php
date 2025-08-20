<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnershipSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('partnership-sections', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:350'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
        ];
    }
}
