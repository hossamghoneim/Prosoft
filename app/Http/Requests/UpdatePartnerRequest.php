<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('partners', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'partnership_section_id' => ['required', 'exists:partnership_sections,id'],
            'title' => ['required', 'string', 'max:70'],
            'description' => ['required', 'string', 'max:600'],
            'button_text' => ['required', 'string', 'max:30'],
            'button_url' => ['required', 'string', 'max:100'],
            'background_color' => ['required', 'string', 'max:20'],
            'inner_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
            'outer_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
            'home_page_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
        ];
    }
}
