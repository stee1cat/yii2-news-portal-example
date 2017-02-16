<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Post;

use app\models\SelectOptionInterface;
use MyCLabs\Enum\Enum;

/**
 * Class PostStatus
 * @package app\models\Post
 *
 * @method static PostStatus DRAFT()
 * @method static PostStatus PUBLISHED()
 */
class PostStatus extends Enum implements SelectOptionInterface
{

    const DRAFT = 0;
    const PUBLISHED = 1;

    public static function getOptions()
    {
        return [
            self::DRAFT => \Yii::t('app/models', 'Draft'),
            self::PUBLISHED => \Yii::t('app/models', 'Published'),
        ];
    }

}