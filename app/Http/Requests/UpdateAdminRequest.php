<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use App\Enums\RegexEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('admins', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $adminId = $this->route('admin');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:admins,email,' . $adminId],
            'phone' => ['nullable', 'string', 'max:255', 'unique:admins,phone,' . $adminId, 'regex:' . RegexEnum::PHONE->value],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
            'password_confirmation' => ['nullable'],
            'password' => ['nullable', 'exclude_if:password,null', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()],
            ];
    }
}
