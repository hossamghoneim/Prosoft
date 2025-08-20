<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsMiddleSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-middle-sections', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:560'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // 5MB
        ];
    }
}
