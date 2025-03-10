<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum PermissionActions: string
{
    case LIST_VIEW = 'list_view';
    case DETAILED_VIEW = 'detailed_view';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';

    public function name(): string
    {
        return match ($this) {
            self::LIST_VIEW => 'list_view',
            self::DETAILED_VIEW => 'detailed_view',
            self::CREATE => 'create',
            self::UPDATE => 'update',
            self::DELETE => 'delete'
        };
    }

    public static function all(): Collection
    {
        return collect(self::cases())->map(fn ($enum) => [
            'value' => $enum->value,
            'name' => $enum->name(),
        ]);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
