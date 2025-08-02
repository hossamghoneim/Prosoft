<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum InquiryTypesEnum: int
{
    case PARTNERSHIP = 0;
    case SOLUTION = 1;
    case CHANNEL_SERVICES = 2;
    case GENERAL = 3;
    case CARRERS = 4;

    public function name(): string
    {
        return match ($this) {
            self::PARTNERSHIP => 'Partnership',
            self::SOLUTION => 'Solution',
            self::CHANNEL_SERVICES => 'Channel_Services',
            self::GENERAL => 'General',
            self::CARRERS => 'Careers'
        };
    }

    public static function fromName(string $name): ?self
    {
        return collect(self::cases())->first(fn ($case) => $case->name() === $name);
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

    public static function names(): array
    {
        return array_map(fn($case) => $case->name(), self::cases());
    }

}
