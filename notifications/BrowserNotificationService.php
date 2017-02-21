<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\User;
use Yii;

/**
 * Class BrowserNotificationService
 * @package app\notifications
 */
class BrowserNotificationService implements NotificationServiceInterface
{

    const NAME = 'browser';

    public function getCode()
    {
        return 'browser';
    }

    public function getName()
    {
        return Yii::t('app/notifications', 'Browser');
    }

    public function getDefaultStatus()
    {
        return true;
    }

    public function notify(User $user, Message $message)
    {
        // nope

        return false;
    }

}