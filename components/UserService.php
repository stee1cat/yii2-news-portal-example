<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use app\models\User;
use Yii;

/**
 * Class UserService
 * @package app\components
 */
class UserService
{

    public function create($login, $password = null)
    {
        if (null === $password) {
            $password = $this->generatePassword();
        }

        $user = new User([
            'login' => $login,
            'auth_key' => $this->generateAuthKey(),
            'password_hash' => Yii::$app->security->generatePasswordHash($password),
        ]);

        return $user->save() ? $user : false;
    }

    /**
     * @return string
     */
    public function generateAuthKey()
    {
        return md5(Yii::$app->security->generateRandomString());
    }

    /**
     * @return string
     */
    public function generatePassword()
    {
        $default = 6;
        $length = isset(Yii::$app->params['passwordLength']) ? max(intval(Yii::$app->params['passwordLength']), $default) : $default;
        return Yii::$app->security->generateRandomString($length);
    }

    /**
     * @return string
     */
    public function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

}