<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DiscountType extends Enum
{
    const time = 'محدودیت زمانی';
    const count = 'محدودیت استفاده';
    const user = 'محدودیت استفاده کننده';
}
