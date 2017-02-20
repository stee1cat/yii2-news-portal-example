<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\handlers\Events;
use Yii;
use yii\base\Behavior;
use yii\base\Event;

/**
 * Class NotificationEventBehavior
 * @package app\notifications
 */
class NotificationEventBehavior extends Behavior
{

    public $events = [];

    public function events()
    {
        $events = [];
        foreach ($this->events as $event) {
            $events[$event] = 'trigger';
        }
        return $events;
    }

    public function trigger(Event $event)
    {
        Yii::$app->eventBus->trigger(Events::NOTIFICATION, new NotificationEvent([
            'sender' => $event->sender,
            'target' => $event,
        ]));
    }

}