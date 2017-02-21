<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package app\forms
 */
class ResetPasswordForm extends Model
{

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
            [['password', 'password_confirm'], 'required'],
            [['password', 'password_confirm'], 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app/forms', 'Password'),
            'password_confirm' => Yii::t('app/forms', 'Password Confirm'),
        ];
    }

}