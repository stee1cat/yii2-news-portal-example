<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\commands;

use app\models\Notification;
use app\models\Notification\Message\MessageStatus;
use app\notifications\Message;
use Yii;
use yii\console\Controller;

/**
 * Class NotificationController
 * @package app\commands
 */
class NotificationController extends Controller
{

    public function actionSend()
    {
        /** @var Notification\Message[] $notifications */
        $notifications = Notification\Message::find()->with('user')->where([
            'status' => MessageStatus::AWAIT()->getValue(),
        ])->all();

        foreach ($notifications as $notification) {
            $message = new Message();
            $message->setSubject($notification->subject)
                ->setText($notification->message);

            if (Yii::$app->notificationManager->notify($notification->service, $notification->user, $message)) {
                $notification->status = MessageStatus::SENT()->getValue();
                $notification->save();
            }
        }
    }

}