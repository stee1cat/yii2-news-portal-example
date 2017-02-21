<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\forms\SendNotificationForm;
use app\models\Role;
use vova07\imperavi\Widget;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var $this View
 * @var $model SendNotificationForm
 * @var $services array
 */

$this->title = Yii::t('app', 'Send Notification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-send">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::t('app', 'Sent'); ?>!</h4>
            <?= Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->dropDownList(array_map(function ($description) {
        return Yii::t('app', $description);
    }, ArrayHelper::map(Role::find()->all(), 'name', 'description'))); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'message')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
        ],
    ]); ?>

    <?= $form->field($model, 'services')->checkboxList(ArrayHelper::map(Yii::$app->notificationManager->getAvailableServices(), 'code', 'label')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>