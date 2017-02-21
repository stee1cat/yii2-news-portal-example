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

        Yii::$app->userService->sendConfirmationCode($user);

        Yii::$app->mailer->compose('user-notify-admin', [
                'id' => $user->id,
                'login' => $user->login,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject(Yii::t('app/mail', 'New user registration'))
            ->send();
    }

    public function onCreatedByAdmin(Event $event)
    {
        /** @var UserModel $user */
        $user = $event->sender;

        $user->status = UserModel\UserStatus::RESET_PASSWORD()->getValue();
        $user->save();

        Yii::$app->mailer->compose('user-created-by-admin', [
                'login' => $user->login,
                'code' => $user->auth_key,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->login)
            ->setSubject(Yii::t('app/mail', 'Confrim your e-mail address'))
            ->send();
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

}