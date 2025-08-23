<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnershipHeroSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('partnership-hero-sections', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:50'],
            'description' => ['required','string','max:440'],
            'button_text' => ['required','string','max:40'],
            'button_url' => ['required','string','max:100'],
            'video_url' => ['nullable','file','mimes:mp4,webm,ogg', 'max:102400'], // 100MB
        ];
    }
}
