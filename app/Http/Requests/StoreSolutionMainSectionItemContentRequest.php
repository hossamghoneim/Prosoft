<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Foundation\Http\FormRequest;

class StoreSolutionMainSectionItemContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('solution-main-section-item-contents', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'solution_main_section_item_id' => 'required|exists:solution_main_section_items,id',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
            'background_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'first_card_title' => 'required|string|max:255',
            'first_card_description' => 'required|string',
            'second_card_title' => 'nullable|string|max:255',
            'second_card_description' => 'nullable|string',
            'third_card_title' => 'nullable|string|max:255',
            'third_card_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'button_text' => 'nullable|string|max:100',
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
            'solution_main_section_item_id.required' => 'The solution main section item field is required.',
            'solution_main_section_item_id.exists' => 'The selected solution main section item is invalid.',
            'main_title.required' => 'The main title field is required.',
            'main_title.string' => 'The main title must be a string.',
            'main_title.max' => 'The main title may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'background_image.required' => 'The background image field is required.',
            'background_image.image' => 'The background image must be an image.',
            'background_image.mimes' => 'The background image must be a file of type: jpeg, png, jpg, gif, webp.',
            'background_image.max' => 'The background image may not be greater than 5MB.',
            'first_card_title.required' => 'The first card title field is required.',
            'first_card_title.string' => 'The first card title must be a string.',
            'first_card_title.max' => 'The first card title may not be greater than 255 characters.',
            'first_card_description.required' => 'The first card description field is required.',
            'first_card_description.string' => 'The first card description must be a string.',
            'second_card_title.string' => 'The second card title must be a string.',
            'second_card_title.max' => 'The second card title may not be greater than 255 characters.',
            'second_card_description.string' => 'The second card description must be a string.',
            'third_card_title.string' => 'The third card title must be a string.',
            'third_card_title.max' => 'The third card title may not be greater than 255 characters.',
            'third_card_description.string' => 'The third card description must be a string.',
            'logo.image' => 'The logo must be an image.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, webp, svg.',
            'logo.max' => 'The logo may not be greater than 2MB.',
            'button_text.string' => 'The button text must be a string.',
            'button_text.max' => 'The button text may not be greater than 100 characters.',
        ];
    }
}
