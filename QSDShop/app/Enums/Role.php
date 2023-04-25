<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self CUSTOMER()
 * @method static self ADMIN()
 * @method static self SUPER_ADMIN()
 */

class Role extends Enum
{
    protected static function values(): array{
        return [
            'CUSTOMER' => 'customer',
            'ADMIN' => 'admin',
            'SUPER_ADMIN' => 'super_admin',
        ];
    }
}
