<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('contact-inquiries', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'inquiry_type' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:1000'],
        ];
    }
}
