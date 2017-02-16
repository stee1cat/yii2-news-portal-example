<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handers;

use yii\base\Event;

/**
 * Class BeforeRequest
 * @package app\handers
 */
class BeforeRequest
{

    /**
     * Регистрация обработчиков событий
     *
     * @param Event $event
     */
    public static function attachListeners(Event $event)
    {
        \Yii::$app->on(Events::USER_SIGNUP, [User::class, 'onSignup']);
    }

}