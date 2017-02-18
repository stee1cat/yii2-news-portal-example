<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
use app\rbac\Roles;
use Yii;
use yii\console\Controller;

/**
 * Команды управления пользователями
 * 
 * Class UserController
 * @package app\commands
 */
class UserController extends Controller
{

    /**
     * @param null $password
     * @return integer
     */
    public function actionCreateAdmin($password = null)
    {
        $admin = Yii::$app->userService->create('admin', $password, Roles::ADMIN);

        if ($admin) {
            $admin->status = User\UserStatus::ACTIVE()->getValue();
            $admin->save();
        }

        return !!$admin;
    }

    /**
     * @param null $password
     * @return integer
     */
    public function actionCreateModerator($password = null)
    {
        $moderator = Yii::$app->userService->create('moderator', $password, Roles::MODERATOR);

        if ($moderator) {
            $moderator->status = User\UserStatus::ACTIVE()->getValue();
            $moderator->save();
        }

        return !!$moderator;
    }

    /**
     * @return integer
     */
    public function actionCheckAdmin()
    {
        return !!User::findByLogin('admin');
    }

}