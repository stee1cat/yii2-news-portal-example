<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use app\models\Notification;
use app\models\Notification\Message\MessageStatus;
use app\models\User;
use app\notifications\NotificationEvent;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class NotificationHandler
 * @package app\handlers
 */
class NotificationHandler
{

    /**
     * Помещает сообщение в очередь
     *
     * @param NotificationEvent $event
     */
    public function push(NotificationEvent $event)
    {
        $model = $event->sender;
        $eventName = $event->target->name;

        /** @var Notification[] $notifications */
        $notifications = Notification::find()->event($eventName)->all();
        foreach ($notifications as $notification) {
            /** @var User[] $users */
            $users = User::find()->role($notification->role)->active()->all();

            foreach ($users as $user) {
                $params = $this->getAttributes($model);
                $message = Yii::$app->notificationTemplateManager->compile($notification, array_merge($params, [
                    '{login}' => $user->login,
                ]));

                $notificationServices = $this->getActiveNotificationServices($notification->types, 'type');
                $userServices = $this->getActiveNotificationServices($user->notifications, 'notification');
                $services = array_intersect($notificationServices, $userServices);

                foreach ($services as $service) {
                    $notificationMessage = new Notification\Message([
                        'user_id' => $user->id,
                        'service' => $service,
                        'subject' => $message->getSubject(),
                        'message' => $message->getText(),
                        'status' => MessageStatus::AWAIT()->getValue(),
                        'params' => json_encode([
                            'event' => $eventName,
                        ]),
                    ]);
                    $notificationMessage->save();
                }
            }
        }
    }

    protected function getAttributes(Model $model)
    {
        $attributes = [];
        foreach ($model->attributeLabels() as $attribute => $attributeLabel) {
            if (isset($model[$attribute])) {
                $attributes[sprintf('{%s}', $attribute)] = $model->$attribute;
            }
        }
        return $attributes;
    }

    /**
     * @todo: Превести связанные модели типов уведомлений пользователя и шаблона сообщения к одному виду
     *
     * @param array $notifications
     * @param string $key
     * @return array
     */
    public function getActiveNotificationServices($notifications, $key)
    {
        $result = [];

        $types = array_filter(ArrayHelper::map($notifications, $key, 'status'), function ($status) {
            return !!$status;
        });

        foreach ($types as $type => $status) {
            $result[] = $type;
        }

        return $result;
    }

}