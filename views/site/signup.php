<?php

use app\forms\SignupForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model SignupForm
 */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1>Регистрация</h1>
<div class="signup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['class' => 'form-control phone']); ?>
    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?= $form->field($model, 'password_confirm')->passwordInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>