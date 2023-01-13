<?php

namespace App\Enums;

enum OrderStatusEnum
{
    case PENDING;
    case PAID;
    case CANCELLED;

    public static function values()
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->name;
        }
        return $values;
    }

    public static function enumOptions()
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[$case->name] = ucfirst(strtolower($case->name));
        }
        return $values;
    }
}
