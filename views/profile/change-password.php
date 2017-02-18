<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\forms\UserProfile\ChangePasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model ChangePasswordForm
 */

$this->title = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="profile-change-password">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::t('app', 'Saved'); ?>!</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="change-password-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'old_password')->passwordInput(); ?>
        <?= $form->field($model, 'new_password')->passwordInput(); ?>
        <?= $form->field($model, 'new_password_confirm')->passwordInput(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>