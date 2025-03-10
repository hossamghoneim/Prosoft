<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use App\Enums\RegexEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAdminPasswordRequest extends FormRequest
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
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'password' => ['required','string','min:6','max:255','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ];
    }
}
