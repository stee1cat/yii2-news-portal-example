<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

/**
 * Class PostPageSizeSelector
 * @package app\widgets
 */
class PostPageSizeSelector extends Widget
{

    public $pageSizes = [10, 20, 50];

    public function run()
    {
        $html = '';

        if (!empty($this->pageSizes)) {
            $html .= $this->renderForm();
            $this->registerJs();
        }

        return $html;
    }

    protected function registerJs()
    {
        $inputId = Yii::$app->postService->pageSizeInput;

        $script = <<< JS
    $('#{$inputId}').on('change', function (event) {
        var date = new Date();
        date.setDate(date.getDate() + 30);
        
        document.cookie = '{$inputId}=' + event.target.value +  '; path=/; expires=' + date.toUTCString();
        
        location.reload();
    });
JS;
        $this->getView()->registerJs($script, View::POS_READY);
    }

    protected function renderForm()
    {
        $inputName = Yii::$app->postService->pageSizeInput;

        $html = '<form class="form-inline pull-right">';
        $html .= '<div class="form-group">';
        $html .= sprintf('<label for="%s">%s&nbsp;</label>', $inputName, Yii::t('app', 'Posts per page'));
        $html .= Html::dropDownList($inputName, Yii::$app->postService->getPageSize(), array_combine($this->pageSizes, $this->pageSizes), [
            'id' => $inputName,
            'class' => 'form-control',
        ]);
        $html .= '</div>';
        $html .= '</form>';

        return $html;
    }

}