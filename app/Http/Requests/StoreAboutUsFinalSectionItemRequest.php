<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreAboutUsFinalSectionItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-final-section-items', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'about_us_final_section_id' => ['required', 'exists:about_us_final_sections,id'],
            'title' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string', 'max:50'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
            'order' => ['required', 'integer', 'min:1'],
        ];
    }
}
