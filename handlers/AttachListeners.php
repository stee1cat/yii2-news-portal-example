<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Class AttachListeners
 * @package app\handlers
 */
class AttachListeners extends Component implements BootstrapInterface
{

    /**
     * Регистрация обработчиков событий
     *
     * @param Application $application
     */
    public function bootstrap($application)
    {
        $userHander = new UserHandler();
        $application->on(Events::USER_SIGNUP, [$userHander, 'onSignup']);
        $application->on(Events::USER_CREATED_BY_ADMIN, [$userHander, 'onCreatedByAdmin']);
        $application->on(Events::USER_PASSWORD_CHANGED, [$userHander, 'onPasswordChanged']);

        $postHandler = new PostHandler();
        $application->on(Events::POST_PUBLISHED, [$postHandler, 'onPublished']);
    }

}