<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use app\models\User as UserModel;
use Yii;
use yii\base\Event;

/**
 * Обработчики событий связанные с пользователем
 *
 * Class UserHandler
 * @package app\handlers
 */
class UserHandler
{

    public function onSignup(Event $event)
    {
        /** @var UserModel $user */
        $user = $event->sender;

        $this->sendSignupMessageToNewUser($user);

        Yii::$app->mailer->compose('user-notify-admin', [
                'id' => $user->id,
                'login' => $user->login,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->login)
            ->setSubject(Yii::t('app/mail', 'New user registration'))
            ->send();
    }

    public function onCreatedByAdmin(Event $event)
    {
        /** @var UserModel $user */
        $user = $event->sender;

        $this->sendSignupMessageToNewUser($user);
    }

    public function onPasswordChanged(Event $event)
    {
        /** @var UserModel $user */
        $user = $event->sender;

        Yii::$app->mailer->compose('user-password-changed', [
                'id' => $user->id,
                'login' => $user->login,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->login)
            ->setSubject(Yii::t('app/mail', 'Password has been changed'))
            ->send();
    }

    protected function sendSignupMessageToNewUser(UserModel $user)
    {
        Yii::$app->mailer->compose('user-signup', [
                'login' => $user->login,
                'code' => $user->auth_key,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->login)
            ->setSubject(Yii::t('app/mail', 'Confrim your e-mail address'))
            ->send();
    }

}