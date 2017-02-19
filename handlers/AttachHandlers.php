<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\handlers;

use BaseApplication;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Class AttachHandlers
 * @package app\handlers
 */
class AttachHandlers extends Component implements BootstrapInterface
{

    /**
     * Регистрация обработчиков событий
     *
     * @param Application|BaseApplication $application
     */
    public function bootstrap($application)
    {
        $userHander = new UserHandler();
        $application->eventBus->on(Events::USER_SIGNUP, [$userHander, 'onSignup']);
        $application->eventBus->on(Events::USER_CREATED_BY_ADMIN, [$userHander, 'onCreatedByAdmin']);
        $application->eventBus->on(Events::USER_PASSWORD_CHANGED, [$userHander, 'onPasswordChanged']);

        $postHandler = new PostHandler();
        $application->eventBus->on(Events::POST_PUBLISHED, [$postHandler, 'onPublished']);
    }

}