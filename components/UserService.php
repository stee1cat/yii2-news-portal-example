<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use app\models\User;
use app\rbac\Roles;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;

/**
 * Class UserService
 * @package app\components
 */
class UserService
{

    public function create($login, $password = null, $role = Roles::USER)
    {
        if (null === $password) {
            $password = $this->generatePassword();
        }

        $user = new User([
            'login' => $login,
            'auth_key' => $this->generateAuthKey(),
            'password_hash' => Yii::$app->security->generatePasswordHash($password),
            'status' => User\UserStatus::INACTIVE()->getValue(),
        ]);

        if ($user->save()) {
            $this->createRole($user, $role);
            $this->createProfile($user);
            $this->createNotifications($user);
        }

        return !$user->isNewRecord ? $user : false;
    }

    /**
     * @return string
     */
    public function generateAuthKey()
    {
        return md5(Yii::$app->security->generateRandomString());
    }

    /**
     * @return string
     */
    public function generatePassword()
    {
        $default = 6;
        $length = isset(Yii::$app->params['passwordLength']) ? max(intval(Yii::$app->params['passwordLength']), $default) : $default;
        return Yii::$app->security->generateRandomString($length);
    }

    /**
     * @return string
     */
    public function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @param integer $userId
     * @return array
     */
    public function getNotifications($userId)
    {
        $notifications = ArrayHelper::map(User\Notification::find()->where([
            'user_id' => $userId,
        ])->all(), 'notification', function (User\Notification $notification) {
            return [
                'value' => (int) $notification->status,
            ];
        });

        return ArrayHelper::merge(Yii::$app->notifications->getAvailableNotifications(), $notifications);
    }

    /**
     * @param integer $userId
     * @param string $password
     * @return boolean
     */
    public function updatePassword($userId, $password)
    {
        $result = false;

        $user = User::findOne($userId);
        if ($user) {
            $user->setAttributes([
                'auth_key' => $this->generateAuthKey(),
                'password_hash' => Yii::$app->security->generatePasswordHash($password),
            ]);

            $result = $user->save();
        }

        return $result;
    }

    public function updateNotifications($userId, $notifications)
    {
        $notifications = !is_array($notifications) ? [] : $notifications;
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $currentNotifications = User\Notification::find()->where([
                'user_id' => $userId,
            ])->select(['notification'])->column();

            User\Notification::updateAll(['status' => 0], [
                'user_id' => $userId,
            ]);

            $available = Yii::$app->notifications->getAvailableNotifications();

            foreach ($notifications as $notification) {
                if (isset($available[$notification])) {
                    if (in_array($notification, $currentNotifications)) {
                        User\Notification::updateAll(['status' => 1], [
                            'user_id' => $userId,
                            'notification' => $notification,
                        ]);
                    }
                    else {
                        $model = new User\Notification([
                            'user_id' => $userId,
                            'notification' => $notification,
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

    protected function createNotifications(User $user)
    {
        $notifications = array_filter(Yii::$app->notifications->getAvailableNotifications(), function ($notification) {
            return !!$notification['value'];
        });

        $services = [];
        foreach ($notifications as $notification) {
            $services[] = $notification['code'];
        }

        $this->updateNotifications($user->id, $services);
    }

    protected function createProfile(User $user)
    {
        $profile = new User\Profile([
            'user_id' => $user->id,
        ]);
        $profile->save();

        $user->link('profile', $profile);
    }

    protected function createRole(User $user, $role)
    {
        /* @var $authManager DbManager  */
        $authManager = Yii::$app->authManager;
        $authManager->assign($authManager->getRole($role), $user->id);
    }

}