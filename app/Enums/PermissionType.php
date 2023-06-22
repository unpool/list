<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermissionType extends Enum
{
    const PRODUCT_MANAGE = 'مدیریت محصولات';
    const COMMENT_MANAGE = 'مدیریت نظرات';
}
