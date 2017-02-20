<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\forms\NotificationForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model app\models\Notification
 * @var $notifications array
 * @var $notificationForm NotificationForm
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notification',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/events', $model->event), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'notifications' => $notifications,
        'notificationForm' => $notificationForm,
    ]) ?>

</div>
