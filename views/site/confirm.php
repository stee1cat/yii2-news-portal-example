<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Подтверждение электронной почты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-confirm">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Для продолжения перейдите по ссылке в письме отправленным на указанный вами адрес электронной почты.
    </p>
</div>
