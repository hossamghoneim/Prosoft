<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceBannerSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('brands', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:30'],
            'description' => ['required','string','max:240'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
        ];
    }
}
