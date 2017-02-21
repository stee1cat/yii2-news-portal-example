<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\forms\NotificationForm;
use app\models\Role;
use vova07\imperavi\Widget;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $model app\models\Notification
 * @var $form yii\widgets\ActiveForm
 * @var $notifications array
 * @var $notificationForm NotificationForm
 */

$events = json_encode(Yii::$app->eventManager->getRegisteredModelAttributes());

$js = <<<JS
    var events = {$events},
        eventField = $('#event-field'),
        attributesList = $('#attributes-list'),
        updateAttributes,
        insertPlaceholder;

    updateAttributes = function (event) {
        var modelAttributes = events[event.target.value],
            list = $('<ul class="list-unstyled"></ul>');
        
        if (modelAttributes) {
            $.each(modelAttributes, function (attribute, title) {
                list.append('<li><a href="#">{' + attribute + '}</a> - ' + title + '</li>');
            });
            
            attributesList.html(list);
            $('a', attributesList).on('click', insertPlaceholder);
        }
    };
    
    insertPlaceholder = function (event) {
        var placeholder = $(this).text().trim();
        
        $('#message-field').redactor('insert.text', placeholder);
        
        event.preventDefault();
    };

    eventField.on('change', updateAttributes);
    eventField.trigger('change');
JS;

$this->registerJs($js, View::POS_READY);
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event')->dropDownList(ArrayHelper::map(Yii::$app->eventManager->getRegisteredEvents(), 'name', 'label'), [
        'id' => 'event-field',
    ]); ?>

    <?= $form->field($model, 'role')->dropDownList(array_map(function ($description) {
        return Yii::t('app', $description);
    }, ArrayHelper::map(Role::find()->all(), 'name', 'description'))); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]); ?>

    <div id="attributes-list"></div>

    <?= $form->field($model, 'message')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
        ],
        'options' => [
            'id' => 'message-field',
        ],
    ]); ?>

    <?= $form->field($notificationForm, 'types')->checkboxList(ArrayHelper::map($notifications, 'code', 'label')); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>