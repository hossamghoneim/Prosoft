<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum SettingEnum: string
{
    case FACEBOOK_URL = 'facebook_url';
    case YOUTUBE_URL = 'youtube_url';
    case INSTAGRAM_URL = 'instagram_url';
    case X_URL = 'x_url';
    case PHONE = 'phone';
    case EMAIL = 'email';
    case ADDRESS = 'address';
    case META_TAG_DESCRIPTION_EN = 'meta_tag_description_en';
    case META_TAG_DESCRIPTION_AR = 'meta_tag_description_ar';

    public function name(): string
    {
        return match ($this) {
            self::FACEBOOK_URL => 'Facebook',
            self::YOUTUBE_URL => 'Youtube',
            self::INSTAGRAM_URL => 'Instagram',
            self::X_URL => 'X',
            self::PHONE => 'Phone',
            self::EMAIL => 'Email',
            self::ADDRESS => 'Address',
            self::META_TAG_DESCRIPTION_EN => 'Meta Tag Description En',
            self::META_TAG_DESCRIPTION_AR => 'Meta Tag Description Ar',
        };
    }

    public static function all(): Collection
    {
        return collect(self::cases())->map(fn ($enum) => [
            'key' => $enum->value,
        ]);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
