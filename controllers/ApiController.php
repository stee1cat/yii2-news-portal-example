<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\controllers;

use app\models\Notification\Message;
use app\notifications\BrowserNotificationService;
use app\rbac\Roles;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class ApiController
 * @package app\controllers
 */
class ApiController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Roles::USER]
                    ],
                ],
            ],
        ];
    }


    public function actionNotification()
    {
        return $this->asJson($this->findNotifications());
    }

    protected function findNotifications()
    {
        $condition = [
            'user_id' => Yii::$app->user->identity->getId(),
            'service' => BrowserNotificationService::NAME,
            'status' => Message\MessageStatus::AWAIT()->getValue(),
        ];

        $notifications = Message::find()->select(['subject', 'message'])->where($condition)->asArray()->all();

        Message::updateAll(['status' => Message\MessageStatus::SENT()->getValue()], $condition);

        return $notifications;
    }

}