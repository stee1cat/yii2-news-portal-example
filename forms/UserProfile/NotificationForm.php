<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms\UserProfile;

use Yii;
use yii\base\Model;

/**
 * Class NotificationForm
 * @package app\forms\UserProfile
 */
class NotificationForm extends Model
{

    public $types = [];

    /**
     * Все доступные типы уведомлений
     *
     * @var array
     */
    protected $notifications = [];

    /**
     * @var string
     */
    public $login;

    public function rules()
    {
        return [
            ['types', 'validateServices'],
        ];
    }

    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        $selected = array_filter($notifications, function ($notification) {
            return !!$notification['value'];
        });

        foreach ($selected as $service) {
            $this->types[] = $service['code'];
        }
    }

    public function validateServices()
    {
        $result = true;

        foreach ($this->types as $type) {
            if (!isset($this->notifications[$type])) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'types' => Yii::t('app', 'Notifications'),
        ];
    }

}