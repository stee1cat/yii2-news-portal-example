<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\forms\ResetPasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model ResetPasswordForm
 */

$this->title = Yii::t('app', 'Reset Password');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="reset-password-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?= $form->field($model, 'password_confirm')->passwordInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>