<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SendType extends Enum
{
    const DOWNLOAD = 'Download';
    const USB = 'USB';
    const CD = 'CD';
}
