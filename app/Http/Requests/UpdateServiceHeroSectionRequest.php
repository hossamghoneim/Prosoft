<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceHeroSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('service-hero-sections', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:30'],
            'description' => ['required','string','max:370'],
            'button_text' => ['required','string','max:35'],
            'button_url' => ['required','string','max:50'],
            'video_url' => ['nullable','file','mimetypes:video/mp4,video/webm', 'max:102400'], // 100MB
        ];
    }
}
