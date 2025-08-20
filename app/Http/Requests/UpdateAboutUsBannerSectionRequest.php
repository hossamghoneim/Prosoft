<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutUsBannerSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-banner-sections', PermissionActions::UPDATE->value);
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
            'description' => ['required', 'string', 'max:200'],
            'button_text' => ['required', 'string', 'max:30'],
            'button_url' => ['required', 'string', 'max:100'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:102400'], // 100MB
        ];
    }
}
