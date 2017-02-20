<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use app\notifications\NotificationEventBehavior;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\base\Model;
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
                $model->attachBehavior('notification', [
                    'class' => NotificationEventBehavior::class,
                    'events' => $events,
                ]);
            });
        }
    }

    /**
     * @return array
     */
    public function getRegisteredEvents()
    {
        $events = [];

        foreach ($this->models as $modelClass => $modelEvents) {
            foreach ($modelEvents as $event) {
                $events[$event] = [
                    'name' => $event,
                    'label' => Yii::t('app/events', $event),
                    'modelClass' => $modelClass,
                ];
            }
        }

        return $events;
    }

    public function getRegisteredModelAttributes()
    {
        $events = [];

        foreach ($this->getRegisteredEvents() as $event) {
            $modelClass = $event['modelClass'];
            if (class_exists($modelClass)) {
                /** @var Model $eventModel */
                $eventModel = new $modelClass();
                $events[$event['name']] = array_merge($eventModel->attributeLabels(), [
                    'login' => 'Логин',
                ]);
            }
        }

        return $events;
    }

}