<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self MALE()
 * @method static self FEMALE()
 * @method static self CHILDREN()
 */
class Gender extends Enum
{
    protected static function values()
    {
        return [
            'MALE' => 'male',
            'FEMALE' => 'female',
            'CHILDREN' => 'children,'
        ];
    }
}
