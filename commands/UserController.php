<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\User;
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
        return !!Yii::$app->userService->create('admin', $password);
    }

    /**
     * @return integer
     */
    public function actionCheckAdmin()
    {
        return !!User::findByLogin('admin');
    }

}