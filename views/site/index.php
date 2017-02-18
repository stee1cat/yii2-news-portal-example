<?php

/**
 * @var $this yii\web\View
 * @var $posts \yii\data\ActiveDataProvider
 */

use yii\widgets\ListView;

$this->title = 'Breaking News';

?>
<div class="site-index">
    <?= ListView::widget([
        'dataProvider' => $posts,
        'itemView' => '_post',
        'summary' => false,
    ]); ?>
</div>
