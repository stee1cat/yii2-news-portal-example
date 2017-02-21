<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * Class ResendConfirmationCodeForm
 * @package app\forms
 */
class ResendConfirmationCodeForm extends Model
{

    public $login;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['login', 'required'],
            ['login', 'email'],
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