<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\controllers;

use app\forms\UserProfile\ChangePasswordForm;
use app\forms\NotificationForm;
use app\handlers\Events;
use app\models\User;
use app\models\User\Profile;
use app\rbac\Roles;
use Yii;
use yii\base\Event;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * Class ProfileController
 * @package app\controllers
 */
class ProfileController extends Controller
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


    public function actionIndex()
    {
        $model = $this->getProfile();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Settings have been updated'));

            return $this->redirect(['index']);
        }
        else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionNotification()
    {
        $currentUser = $this->getCurrentUser();
        $notifications = Yii::$app->userService->getNotifications($currentUser->id);

        $model = new NotificationForm();
        $model->setNotifications($notifications);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->userService->updateNotifications($currentUser->id, $model->types);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Notifications has been updated'));

            return $this->redirect(['notification']);
        }
        else {
            return $this->render('notification', [
                'model' => $model,
                'notifications' => $notifications,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $user = $this->getCurrentUser();

        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if (Yii::$app->userService->updatePassword($user->getId(), $model->new_password)) {
                Yii::$app->eventBus->trigger(Events::USER_PASSWORD_CHANGED, new Event([
                    'sender' => $user,
                ]));
            }

            Yii::$app->session->setFlash('success', Yii::t('app', 'Password has been changed'));

            return $this->redirect(['change-password']);
        }
        else {
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return null|Profile
     * @throws NotFoundHttpException
     */
    protected function getProfile()
    {
        if (($model = $this->getCurrentUser()->profile) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return null|IdentityInterface|User
     */
    protected function getCurrentUser()
    {
        return Yii::$app->user->identity;
    }

}