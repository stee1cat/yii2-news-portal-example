<?php

use app\forms\SignupForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model SignupForm
 */

$this->title = Yii::t('app', 'Sign Up');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="signup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['class' => 'form-control phone']); ?>
    <?= $form->field($model, 'password')->passwordInput(); ?>
    <?= $form->field($model, 'password_confirm')->passwordInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-success']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>