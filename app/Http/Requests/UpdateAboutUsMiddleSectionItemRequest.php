<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsMiddleSectionItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-middle-section-items', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'about_us_middle_section_id' => ['required', 'exists:about_us_middle_sections,id'],
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:130'],
            'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // 2MB
            'order' => ['required', 'integer', 'min:1'],
        ];
    }
}
