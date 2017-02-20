<?php

namespace app\controllers\admin;

use app\forms\NotificationForm;
use app\rbac\Roles;
use Yii;
use app\models\Notification;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Roles::ADMIN]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Notification::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Notification model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $model = new Notification();

        $notifications = Yii::$app->notificationTemplateManager->getNotifications($model->id);
        $notificationForm = new NotificationForm();
        $notificationForm->setNotifications($notifications);

        if ($model->load($data) && $notificationForm->load($data) && $model->save()) {
            Yii::$app->notificationTemplateManager->updateNotificationTypes($model->id, $notificationForm->types);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'notifications' => $notifications,
                'notificationForm' => $notificationForm,
            ]);
        }
    }

    /**
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $data = Yii::$app->request->post();
        $model = $this->findModel($id);

        $notifications = Yii::$app->notificationTemplateManager->getNotifications($model->id);
        $notificationForm = new NotificationForm();
        $notificationForm->setNotifications($notifications);

        if ($model->load($data) && $notificationForm->load($data) && $model->save()) {
            Yii::$app->notificationTemplateManager->updateNotificationTypes($model->id, $notificationForm->types);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'notifications' => $notifications,
                'notificationForm' => $notificationForm,
            ]);
        }
    }

    /**
     * Deletes an existing Notification model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
