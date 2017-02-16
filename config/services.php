<?php

use app\services\UserService;

// @todo: DI container
return [
    'userService' => function () {
        return new UserService();
    },
];