<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAboutUsFeatureItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('about-us-feature-items', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'about_us_feature_id' => ['required','integer','exists:about_us_features,id'],
            'icon' => ['required','image','mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'], // 2MB
            'title' => ['required','string','max:30'],
            'description' => ['required','string','max:180'],
        ];
    }
}
