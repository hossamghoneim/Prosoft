<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('roles', PermissionActions::UPDATE->value);
    }
    /**
     * Get the validation rules that apply to the request.
     *
      * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_ar'=>['required', 'string', 'max:255'],
            'name_en'=>['required', 'string', 'max:255'],
            'permissions' => ['required'],
            'permissions.*' => ['required', 'array'],
            'permissions.*.*' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'permissions' => json_decode($this->input('permissions'), true) ?? []
        ]);
    }
}
