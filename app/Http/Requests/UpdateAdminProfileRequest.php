<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use App\Enums\RegexEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAdminProfileRequest extends FormRequest
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
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required','string','max:255','unique:admins,id,' . auth()->id() ],
            'email'    => ['required','string','email','unique:admins,id,' . auth()->id() ]
        ];
    }
}
