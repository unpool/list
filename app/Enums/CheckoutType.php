<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *
 */
final class CheckoutType extends Enum
{
    const WALLET = "کیف پول";
    const CASH = "پرداخت نقدی";
    const READ = [
        self::CASH => self::CASH,
        self::WALLET => self::WALLET,
    ];
}
