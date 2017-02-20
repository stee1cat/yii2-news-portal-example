<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use yii\base\Event;
use yii\base\Model;

/**
 * Class NotificationEvent
 * @package app\notifications
 */
class NotificationEvent extends Event
{

    /**
     * @var Event
     */
    public $target;

    /**
     * @var Model
     */
    public $sender;

}