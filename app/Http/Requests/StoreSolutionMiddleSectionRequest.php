<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSolutionMiddleSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'solution_id' => 'required|exists:solutions,id',
            'main_title' => 'required|string|max:255',
            'first_card_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_card_title' => 'nullable|string|max:255',
            'first_card_description' => 'nullable|string|max:500',
            'second_card_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'second_card_title' => 'nullable|string|max:255',
            'second_card_description' => 'nullable|string|max:500',
            'third_card_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'third_card_title' => 'nullable|string|max:255',
            'third_card_description' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'solution_id.required' => 'The solution field is required.',
            'solution_id.exists' => 'The selected solution is invalid.',
            'main_title.required' => 'The main title field is required.',
            'main_title.string' => 'The main title must be a string.',
            'main_title.max' => 'The main title may not be greater than 255 characters.',
        ];
    }
}
