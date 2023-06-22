<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderType extends Enum
{
    const BUYNODE = 'خرید محصول';
    const CHARGEWALLET = 'شارژ کیف پول';
    const BUYPLAN = 'خرید اشتراک';
}
