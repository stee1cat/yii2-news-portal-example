<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\components\PostService;
use app\components\UserService;
use yii\caching\FileCache;
use yii\rbac\DbManager;

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
        'db' => require(__DIR__ . '/db.php'),
        'postService' => PostService::class,
        'userService' => UserService::class,
    ],
];