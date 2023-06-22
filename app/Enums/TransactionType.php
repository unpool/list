<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionType extends Enum
{
    const SPIN = 'spin';
    const INVITE = 'invite';
    const GATEWAY = 'gateway';
    const POS = 'pos';
    const WALLET = 'wallet';
    const NODE = 'node';
    const CARD = 'card';
}
