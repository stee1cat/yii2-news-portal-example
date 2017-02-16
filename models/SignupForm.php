<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Форма регистрации
 *
 * Class SignupForm
 * @package app\models
 */
class SignupForm extends Model
{

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $password_confirm;

    public function rules()
    {
        return [
            [['login', 'password', 'password_confirm'], 'required'],
            ['login', 'email'],
            [['password', 'password_confirm'], 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
            ['login', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'login',
                'message' => Yii::t('app', 'Пользователь с таким логином уже существует.'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Пароль'),
            'password_confirm' => Yii::t('app', 'Поддтверждение пароля'),
        ];
    }

}
