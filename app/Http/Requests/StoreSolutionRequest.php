<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('solutions', PermissionActions::CREATE->value);
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
            'slug' => ['nullable', 'string', 'max:20', 'unique:solutions,slug'],
        ];
    }
}
