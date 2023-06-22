<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentType extends Enum
{
    const CASH = 'cash';
    const COIN = 'coin';
}
