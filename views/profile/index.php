<?php
/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\models\Post\PostsPerPage;
use app\models\User\Profile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Profile $model
 */

$this->title = Yii::t('app', 'Settings');

?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i><?= Yii::t('app', 'Saved'); ?>!</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="profile-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'posts_per_page')->dropDownList(PostsPerPage::getOptions()); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
