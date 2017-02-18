<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Post;

use app\models\SelectOptionInterface;
use MyCLabs\Enum\Enum;

/**
 * Class PostsPerPage
 * @package app\models\Post
 *
 * @method static PostsPerPage N_10()
 * @method static PostsPerPage N_20()
 * @method static PostsPerPage N_50()
 */
class PostsPerPage extends Enum implements SelectOptionInterface
{

    const N_10 = 10;
    const N_20 = 20;
    const N_50 = 50;

    public static function getOptions()
    {
        return [
            self::N_10 => \Yii::t('app/models', '10'),
            self::N_20 => \Yii::t('app/models', '20'),
            self::N_50 => \Yii::t('app/models', '50'),
        ];
    }

}