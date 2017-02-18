<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\User;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class NotificationManager
 * @package app\notifications
 */
class NotificationManager extends Component
{

    public $services = [];

    /**
     * @var NotificationServiceInterface[]
     */
    protected $notificationServices = [];

    public function init()
    {
        if (is_array($this->services)) {
            foreach ($this->services as $serviceConfig) {
                /** @var NotificationServiceInterface $notificationService */
                $notificationService = Yii::createObject($serviceConfig);
                $this->register($notificationService);
            }
        }
    }

    public function register(NotificationServiceInterface $notificationService)
    {
        $this->notificationServices[$notificationService->getCode()] = $notificationService;
    }

    public function notify(User $user, Message $message)
    {
        if (!empty($this->notificationServices)) {
            $userNotifications = ArrayHelper::map($user->notifications, 'notification', 'id');

            foreach ($this->notificationServices as $notificationService) {
                if (isset($userNotifications[$notificationService->getCode()])) {
                    $notificationService->notify($user, $message);
                }
            }
        }
    }

    public function notifyAll(Message $message)
    {
        $users = User::find()->allUsers()->active()->all();

        foreach ($users as $user) {
            $this->notify($user, $message);
        }
    }

    public function getAvailableNotifications()
    {
        $notifications = [];
        foreach ($this->notificationServices as $code => $notificationService) {
            $notifications[$code] = [
                'code' => $notificationService->getCode(),
                'label' => $notificationService->getName(),
                'value' => (int) $notificationService->getDefaultStatus(),
            ];
        }

        return $notifications;
    }

}