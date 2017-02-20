<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */

$this->title = sprintf('%s #%d', Yii::t('app/events', $model->event), $model->id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="notification-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'event',
                'value' => Yii::t('app/events', $model->event),
            ],
            'subject',
            'message:html',
            [
                'attribute' => 'types',
                'value' => function () use ($model) {
                    $notifications = $model->getTypes()->active()->select('type')->column();

                    array_walk($notifications, function (&$notification, $index, $notifications) {
                        $notification =  isset($notifications[$notification]) ? $notifications[$notification]['label'] : $notification;
                    }, Yii::$app->notificationManager->getAvailableServices());

                    return !empty($notifications) ? implode(', ', $notifications) : null;
                },
            ],
            [
                'attribute' => 'role',
                'value' => Yii::t('app', $model->group->description),
            ],
        ],
    ]) ?>

</div>
