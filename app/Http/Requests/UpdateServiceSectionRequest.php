<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceSectionRequest extends FormRequest
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
        $serviceSectionId = $this->route('service_section');
        return [
            'title' => ['required','string','max:30'],
            'slug' => ['required','string','max:30','unique:service_sections,slug,' . $serviceSectionId],
            'order' => ['nullable','integer','min:1'],
        ];
    }
}
