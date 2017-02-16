<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Форма создания пользователя
 *
 * Class UserForm
 * @package app\forms
 */
class UserForm extends Model
{

    /**
     * @var string
     */
    public $login;

    public function rules()
    {
        return [
            ['login', 'required'],
            ['login', 'email'],
            ['login', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'login',
                'message' => Yii::t('app', 'User already exists'),
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
        ];
    }

}