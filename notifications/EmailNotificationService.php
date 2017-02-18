<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\User;
use Yii;

/**
 * Class EmailNotificationService
 * @package app\notifications
 */
class EmailNotificationService implements NotificationServiceInterface
{

    public $from;

    public function getCode()
    {
        return 'email';
    }

    public function getName()
    {
        return Yii::t('app/notifications', 'E-mail');
    }

    public function getDefaultStatus()
    {
        return true;
    }

    public function notify(User $user, Message $message)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->getFrom())
            ->setTo($user->login)
            ->setSubject($message->getSubject())
            ->setHtmlBody($message->getText())
            ->send();
    }

    protected function getFrom()
    {
        return $this->from ?: Yii::$app->params['adminEmail'];
    }

}