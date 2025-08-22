<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeSecondarySectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('home-secondary-sections', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'main_title' => ['required', 'string', 'max:100'],
            'main_description' => ['required', 'string', 'max:1000'],
            'background_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:10240'], // 10MB
            'first_card_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // 2MB
            'first_card_title' => ['required', 'string', 'max:100'],
            'first_card_description' => ['required', 'string', 'max:500'],
            'second_card_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // 2MB
            'second_card_title' => ['required', 'string', 'max:100'],
            'second_card_description' => ['required', 'string', 'max:500'],
            'third_card_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // 2MB
            'third_card_title' => ['required', 'string', 'max:100'],
            'third_card_description' => ['required', 'string', 'max:500'],
        ];
    }
}
