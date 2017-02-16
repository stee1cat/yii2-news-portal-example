<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use app\handlers\Events;
use app\handlers\PostHandler;
use app\handlers\UserHandler;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Class AttachListeners
 * @package app\components
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

        $postHandler = new PostHandler();
        $application->on(Events::POST_PUBLISHED, [$postHandler, 'onPublished']);
    }

}