<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\notifications;

use app\models\Notification;
use Exception;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class NotificationTemplateManager
 * @package app\notifications
 */
class NotificationTemplateManager extends Component
{

    /**
     * @param Notification $template
     * @param array $params
     * @return Message
     */
    public function compile(Notification $template, array $params)
    {
        $message = new Message();
        $message->setSubject($this->replace($template->subject, $params))
            ->setText($this->replace($template->message, $params));

        return $message;
    }

    /**
     * @param integer $notificationId
     * @return array
     */
    public function getNotifications($notificationId)
    {
        $notifications = ArrayHelper::map(Notification\Type::find()->where([
            'notification_id' => $notificationId,
        ])->all(), 'type', function (Notification\Type $type) {
            return [
                'value' => (int) $type->status,
            ];
        });

        return ArrayHelper::merge(Yii::$app->notificationManager->getAvailableServices(), $notifications);
    }

    public function updateNotificationTypes($notificationId, $notifications)
    {
        $notifications = !is_array($notifications) ? [] : $notifications;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $currentNotifications = Notification\Type::find()->where([
                'notification_id' => $notificationId,
            ])->select(['type'])->column();

            Notification\Type::updateAll(['status' => 0], [
                'notification_id' => $notificationId,
            ]);

            $available = Yii::$app->notificationManager->getAvailableServices();

            foreach ($notifications as $notification) {
                if (isset($available[$notification])) {
                    if (in_array($notification, $currentNotifications)) {
                        Notification\Type::updateAll(['status' => 1], [
                            'notification_id' => $notificationId,
                            'type' => $notification,
                        ]);
                    }
                    else {
                        $model = new Notification\Type([
                            'notification_id' => $notificationId,
                            'type' => $notification,
                            'status' => 1,
                        ]);
                        $model->save();
                    }
                }
            }

            $transaction->commit();
        }
        catch (Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    protected function replace($string, array $params)
    {
        return str_ireplace(array_keys($params), array_values($params), $string);
    }

}