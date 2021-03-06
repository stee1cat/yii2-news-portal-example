<?php

use app\components\PostService;
use app\components\UserService;
use app\handlers\EventBus;
use app\handlers\EventManager;
use app\notifications\NotificationManager;
use app\notifications\NotificationTemplateManager;

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii {

    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;

}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property UserService $userService
 * @property PostService $postService
 * @property NotificationManager $notificationManager
 * @property NotificationTemplateManager $notificationTemplateManager
 * @property EventBus $eventBus
 * @property EventManager $eventManager
 */
abstract class BaseApplication extends yii\base\Application {
}

/**
 * Class WebApplication
 * Include only Web application related components here
 */
class WebApplication extends yii\web\Application {}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 */
class ConsoleApplication extends yii\console\Application {}