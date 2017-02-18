<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\User;

use app\models\SelectOptionInterface;
use MyCLabs\Enum\Enum;

/**
 * Class UserStatus
 * @package app\models\User
 *
 * @method static UserStatus INACTIVE()
 * @method static UserStatus ACTIVE()
 */
class UserStatus extends Enum implements SelectOptionInterface
{

    const INACTIVE = 0;
    const ACTIVE = 1;

    public static function getOptions()
    {
        return [
            self::INACTIVE => \Yii::t('app/models', 'Inactive'),
            self::ACTIVE => \Yii::t('app/models', 'Active'),
        ];
    }

}