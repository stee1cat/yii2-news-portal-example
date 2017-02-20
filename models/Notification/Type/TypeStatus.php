<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Notification\Type;

use MyCLabs\Enum\Enum;

/**
 * Class UserStatus
 * @package app\models\Notification\Type
 *
 * @method static TypeStatus INACTIVE()
 * @method static TypeStatus ACTIVE()
 */
class TypeStatus extends Enum
{

    const INACTIVE = 0;
    const ACTIVE = 1;

}