<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PriceType extends Enum
{
    const CASH = 'cash';
    const COIN = 'coin';
    const FLASH = 'flash';
    const DVD = 'dvd';
}
