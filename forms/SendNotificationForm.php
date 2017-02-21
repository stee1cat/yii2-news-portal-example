<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\forms;

use app\models\Role;
use Yii;
use yii\base\Model;

/**
 * Class SendNotificationForm
 * @package app\forms
 */
class SendNotificationForm extends Model
{

    /**
     * @var string
     */
    public $role;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $services;

    /**
     * Все доступные типы уведомлений
     *
     * @var array
     */
    protected $notifications = [];

    public function init()
    {
        $services = Yii::$app->notificationManager->getAvailableServices();

        $selected = array_filter($services, function ($service) {
            return !!$service['value'];
        });

        foreach ($selected as $service) {
            $this->services[] = $service['code'];
        }
    }

    public function rules()
    {
        return [
            [['role', 'subject', 'message', 'services'], 'required'],
            ['role', 'in', 'range' => Role::find()->select(['name'])->column()],
            ['services', 'validateServices'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role' => Yii::t('app/forms', 'Role'),
            'subject' => Yii::t('app/forms', 'Subject'),
            'message' => Yii::t('app/forms', 'Message'),
            'services' => Yii::t('app', 'Notifications'),
        ];
    }

    public function validateServices()
    {
        $result = true;
        $services = Yii::$app->notificationManager->getAvailableServices();

        foreach ($this->services as $service) {
            if (!isset($services[$service])) {
                $result = false;
            }
        }

        return $result;
    }

}