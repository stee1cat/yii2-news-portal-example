<?php

/**
 * @var $this yii\web\View
 * @var $posts \yii\data\ActiveDataProvider
 */

use app\widgets\PostPageSizeSelector;
use yii\widgets\ListView;

$this->title = 'Breaking News';

?>
<div class="site-index">
    <?= ListView::widget([
        'dataProvider' => $posts,
        'itemView' => '_post',
        'summary' => '<div class="summary col-md-12">' . PostPageSizeSelector::widget() . '</div>',
    ]); ?>
</div>
