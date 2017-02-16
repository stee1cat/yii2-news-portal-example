<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handers;

use app\models\User as UserModel;
use Yii;
use yii\base\Event;

/**
 * Обработчики событий связанные с пользователем
 *
 * Class User
 * @package app\handers
 */
class User
{

    public function onSignup(Event $event)
    {
        /** @var UserModel $user */
        $user = $event->sender;

        Yii::$app->mailer->compose('user-signup', [
                'login' => $user->login,
                'code' => $user->auth_key,
            ])
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->login)
            ->setSubject('Подтверждение e-mail')
            ->send();
    }

}