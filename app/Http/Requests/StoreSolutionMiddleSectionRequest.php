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
            'title' => 'required|string|max:255',
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
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
        ];
    }
}
