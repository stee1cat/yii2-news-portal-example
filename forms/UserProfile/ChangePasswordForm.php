<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms\UserProfile;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * Class ChangePasswordForm
 * @package app\forms\UserProfile
 */
class ChangePasswordForm extends Model
{

    /**
     * @var string
     */
    public $old_password;

    /**
     * @var string
     */
    public $new_password;

    /**
     * @var string
     */
    public $new_password_confirm;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'new_password_confirm'], 'required'],
            [['new_password', 'new_password_confirm'], 'string', 'min' => 6],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password'],
            ['old_password', 'validateOldPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'old_password' => Yii::t('app/forms', 'Old Password'),
            'new_password' => Yii::t('app/forms', 'New Password'),
            'new_password_confirm' => Yii::t('app/forms', 'New Password Confirm'),
        ];
    }

    public function validateOldPassword($attribute)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $password = $this->{$attribute};

        if (!Yii::$app->security->validatePassword($password, $user->password_hash)) {
            $this->addError($attribute, Yii::t('app/forms', 'Old password is incorrect'));
            return false;
        }
    }

}