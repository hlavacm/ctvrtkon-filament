<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum RoleEnum: string implements HasColor
{
    case GUEST = "guest";
    case MEMBER = "member";
    case EDITOR = "editor";
    case ADMIN = "admin";

    public static function keys(): array
    {
        return array_column(RoleEnum::cases(), "value");
    }

    public static function options(): array
    {
        $keys = self::keys();
        return array_combine($keys, $keys);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GUEST => "gray",
            self::MEMBER => "warning",
            self::EDITOR => "success",
            self::ADMIN => "danger",
        };
    }
}
