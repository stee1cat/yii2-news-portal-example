<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use app\models\Post as PostModel;
use yii\base\Event;

/**
 * Обработчики событий связанных с публикацией
 *
 * Class PostHandler
 * @package app\handlers
 */
class PostHandler
{

    public function onPublished(Event $event)
    {
        /** @var PostModel $post */
        $post = $event->sender;
    }

}