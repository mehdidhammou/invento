<?php

namespace App\Enums;

enum SaleStatusEnum
{
    case PAID;
    case UNPAID;

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

    public static function enumColors()
    {
        $values = [];

        $colors = [
            'success',
            'danger',
        ];

        $i = 0;
        foreach (self::cases() as $case) {
            $values[$colors[$i]] = $case->name;
            $i = ($i + 1) % count($colors);
        }

        return $values;

    }
}
