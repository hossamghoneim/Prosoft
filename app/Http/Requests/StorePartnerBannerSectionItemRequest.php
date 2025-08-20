<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StorePartnerBannerSectionItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('partner-banner-section-items', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'partner_banner_section_id' => ['required', 'exists:partner_banner_sections,id'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:5120'], // 5MB
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:120'],
            'is_active' => ['boolean'],
        ];
    }
}
