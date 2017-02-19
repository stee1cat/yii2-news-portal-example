<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use Yii;
use yii\base\Behavior;
use yii\base\Event;

/**
 * Class EventBehavior
 * @package app\handlers
 */
class EventBehavior extends Behavior
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
        Yii::$app->eventBus->trigger($event->name, new Event([
            'sender' => $event->sender,
        ]));
    }

}