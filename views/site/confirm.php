<?php

use app\forms\ResendConfirmationCodeForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Подтверждение электронной почты';
$this->params['breadcrumbs'][] = $this->title;

/**
 * @var $this View
 * @var $model ResendConfirmationCodeForm
 */

?>
<div class="site-confirm">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::t('app', 'Sent'); ?>!</h4>
            <?= Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <p>
        Для продолжения перейдите по ссылке в письме отправленным на указанный вами адрес электронной почты.
        Так же вы можете повторно отправить код воспользовавшись формой ниже.
    </p>
    <div class="confirmation-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login')->textInput(['maxlength' => true]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
