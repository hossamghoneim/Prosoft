<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use App\Enums\RegexEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('admins', PermissionActions::CREATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:admins,email'],
            'phone' => ['required', 'string', 'max:255', 'unique:admins,phone', 'regex:' . RegexEnum::PHONE->value],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'], // TODO :: check if the admin is a vendor so the role_id will contains its vendor_id and if super admin ( app('current-vendor') is null ) so vendor id of role should be null
            'password_confirmation' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()],
            ];

    }
}
