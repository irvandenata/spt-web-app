<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class View
{
    public static function currency(int $value)
    {
        return number_format($value, 0, '.', ',') . ' đ';
    }
}
