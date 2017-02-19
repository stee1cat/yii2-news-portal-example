<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * Class EventManager
 * @package app\handlers
 */
class EventManager extends Component implements BootstrapInterface
{

    public $models = [];

    /**
     * @param Application $application
     */
    public function bootstrap($application)
    {
        /**
         * Добавляем поведение для моделей события которых мы хотим слушать.
         * Так же передаём в поведение список интересующих нас событий.
         */
        foreach ($this->models as $modelClass => $events) {
            Event::on($modelClass, ActiveRecord::EVENT_INIT, function ($event) use ($events) {
                $model = $event->sender;
                /** @var ActiveRecord $model */
                $model->attachBehavior('event', [
                    'class' => EventBehavior::class,
                    'events' => $events,
                ]);
            });
        }
    }

}