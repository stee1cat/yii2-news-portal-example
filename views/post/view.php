<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\models\Post;
use yii\helpers\Html;

/**
 * @var Post $model
 */

?>
<div class="post">
    <h2 class="post__title"><?= Html::encode($model->title); ?></h2>
    <p class="post__date"><?= Yii::$app->formatter->asDatetime($model->updated_at); ?></p>
    <div class="post__detail-text">
        <?= $model->detail_text; ?>
    </div>
</div>
