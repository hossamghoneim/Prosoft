<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactUsSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('contact-us-sections', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_us_content_id' => ['required', 'exists:contact_us_contents,id'],
            'title' => ['required', 'string', 'max:30'],
            'description' => ['required', 'string', 'max:150'],
        ];
    }
}
