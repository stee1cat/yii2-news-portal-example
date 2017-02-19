<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\components\PostService;
use app\components\UserService;
use app\handlers\EventBus;
use app\handlers\EventManager;
use app\handlers\Events;
use app\models\Post;
use app\models\User;
use app\notifications\BrowserNotificationService;
use app\notifications\EmailNotificationService;
use app\notifications\NotificationManager;
use yii\caching\FileCache;
use yii\i18n\PhpMessageSource;
use yii\rbac\DbManager;

require '../handlers/Events.php';

return [
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'components' => [
        'cache' => FileCache::class,
        'authManager' => [
            'class' => DbManager::class,
            'defaultRoles' => [
                'guest', 'admin'
            ],
            'assignmentTable' => 'user_role',
            'itemTable' => 'role',
            'itemChildTable' => 'role_child',
            'ruleTable' => 'rule'
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/model' => 'app/models.php',
                        'app/notifications' => 'app/notifications.php',
                    ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'postService' => PostService::class,
        'userService' => UserService::class,
        'eventBus' => EventBus::class,
        'eventManager' => [
            'class' => EventManager::class,
            'models' => [
                Post::class => [
                    Events::POST_PUBLISHED,
                ],
                User::class => [
                    Events::USER_SIGNUP,
                    Events::USER_CREATED_BY_ADMIN,
                    Events::USER_UPDATED_BY_ADMIN,
                    Events::USER_PASSWORD_CHANGED,
                ],
            ],
        ],
        'notificationManager' => [
            'class' => NotificationManager::class,
            'services' => [
                [
                    'class' => EmailNotificationService::class,
                    'from' => 'notification@news.local',
                ],
                BrowserNotificationService::class,
            ],
        ],
    ],
];