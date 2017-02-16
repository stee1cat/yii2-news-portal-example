<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\controllers;

use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PostController
 * @package app\controllers
 */
class PostController extends Controller
{

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}