<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreAboutUsHeroSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-hero-sections', PermissionActions::CREATE->value);
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
            'description' => ['required', 'string', 'max:370'],
            'button_text' => ['required', 'string', 'max:40'],
            'button_url' => ['required', 'string', 'max:50'],
            'video_url' => ['required', 'file', 'mimetypes:video/mp4,video/webm', 'max:102400'], // 100MB
        ];
    }
}
