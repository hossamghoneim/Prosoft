<?php

namespace App\Http\Requests;

use App\Enums\PermissionActions;
use App\Enums\RegexEnum;
use App\Enums\SettingEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return can('settings', PermissionActions::UPDATE->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'facebook_url'  => [  'nullable', 'url' , 'string' , 'max:255'  ],
            'twitter_url'   => [  'nullable', 'url' , 'string' , 'max:255'  ],
            'instagram_url' => [  'nullable', 'url' , 'string' , 'max:255'  ],
            'youtube_url'   => [  'nullable', 'url' , 'string' , 'max:255'  ],
            'snapchat_url'  => [  'nullable', 'url' , 'string' , 'max:255'  ],
            'email'         => [  'nullable', 'email' , 'max:255'  ],
            'phone'         => [  'nullable', 'regex:' . RegexEnum::PHONE->value ],
            'meta_tag_description_ar' => [ 'nullable' , 'string' , 'max:255'  ],
            'meta_tag_description_en' => [ 'nullable' , 'string' , 'max:255'  ],
            ];
    }
}
