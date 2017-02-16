<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use app\handlers\Events;
use app\handlers\User;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class AttachListeners
 * @package app\components
 */
class AttachListeners implements BootstrapInterface
{

    /**
     * Регистрация обработчиков событий
     *
     * @param Application $application
     */
    public function bootstrap($application)
    {
        $application->on(Events::USER_SIGNUP, [User::class, 'onSignup']);
    }

}