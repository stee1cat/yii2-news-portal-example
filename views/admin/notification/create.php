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

$this->title = Yii::t('app', 'Create Notification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'notifications' => $notifications,
        'notificationForm' => $notificationForm,
    ]) ?>

</div>
