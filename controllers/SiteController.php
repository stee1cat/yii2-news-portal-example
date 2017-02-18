<?php

namespace app\controllers;

use app\handlers\Events;
use app\forms\SignupForm;
use app\models\Post;
use app\models\User;
use Yii;
use yii\base\Event;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\forms\LoginForm;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $pageSize = Yii::$app->postService->getPageSize();

        $posts = new ActiveDataProvider([
            'query' => Post::find()->published(),
            'pagination' => [
                'pageSize' => $pageSize,
                'defaultPageSize' => $pageSize,
                'forcePageParam' => false,
            ],
        ]);

        return $this->render('index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = Yii::$app->userService->create($model->login, $model->password);

            if ($user) {
                \Yii::$app->trigger(Events::USER_SIGNUP, new Event([
                    'sender' => $user,
                ]));
            }

            return $this->redirect('confirm');
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionConfirm()
    {
        $code = Yii::$app->request->get('code');
        $login = Yii::$app->request->get('login');

        if ($login && $code) {
            $user = User::findOne([
                'login' => $login,
                'auth_key' => $code,
                'status' => User\UserStatus::INACTIVE()->getValue(),
            ]);

            if ($user) {
                $user->status = User\UserStatus::ACTIVE()->getValue();
                $user->update();

                Yii::$app->user->login($user);

                return $this->redirect('/');
            }
        }

        return $this->render('confirm');
    }

}
