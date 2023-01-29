<?php

namespace App\Services;


class WidgetService
{

    public static function generateRandomColors($n)
    {
        $colors = [
            0 => "rgb(228, 163, 244)",
            1 => "rgb(218, 141, 197)",
            2 => "rgb(178, 238, 174)",
            3 => "rgb(191, 134, 229)",
            4 => "rgb(129, 134, 165)",
            5 => "rgb(154, 157, 162)",
            6 => "rgb(251, 214, 175)",
            7 => "rgb(219, 249, 209)",
            8 => "rgb(134, 217, 232)",
            9 => "rgb(168, 177, 206)",
            10 => "rgb(240, 140, 170)",
            11 => "rgb(240, 170, 204)",
        ];
        return array_slice($colors, 0, $n);
    }
}
