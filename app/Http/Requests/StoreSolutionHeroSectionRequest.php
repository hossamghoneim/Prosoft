<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolutionHeroSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('solution-hero-sections', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'solution_id' => ['required', 'exists:solutions,id'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:500'],
            'button_text' => ['required', 'string', 'max:50'],
            'button_url' => ['required', 'string', 'max:200'],
            'video_url' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:102400'], // 100MB
        ];
    }
}
