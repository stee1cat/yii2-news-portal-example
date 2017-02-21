<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\User;
use Yii;
use yii\base\Component;

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

    public function notify($service, User $user, Message $message)
    {
        $result = false;

        if (!empty($this->notificationServices) && isset($this->notificationServices[$service])) {
            /** @var NotificationServiceInterface $notificationService */
            $notificationService = $this->notificationServices[$service];

            $result = $notificationService->notify($user, $message);
        }

        return $result;
    }

    public function notifyAll($service, $role, Message $message)
    {
        $users = User::find()->role($role)->active()->all();

        foreach ($users as $user) {
            $this->notify($service, $user, $message);
        }
    }

    public function getAvailableServices()
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