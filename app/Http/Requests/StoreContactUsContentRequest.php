<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactUsContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('contact-us-contents', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:20'],
            'description' => ['required', 'string', 'max:110'],
            'video_url' => ['required', 'file', 'mimetypes:video/mp4,video/webm', 'max:102400'], // 100MB
            'contact_email' => ['required', 'email', 'max:50'],
            'contact_phone' => ['required', 'string', 'max:20'],
        ];
    }
}
