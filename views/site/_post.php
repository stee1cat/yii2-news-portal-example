<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use app\models\Post;
use app\rbac\Roles;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Post $model
 */

?>
<div class="col-md-12 post">
    <h2 class="post__title"><?= Html::encode($model->title); ?> <small><?= Yii::$app->formatter->asDatetime($model->updated_at); ?></small></h2>
    <div class="post__preview-text">
        <?= $model->preview_text; ?>
    </div>
    <?php if (Yii::$app->user->can(Roles::USER)) { ?>
    <p>
        <a class="btn btn-default" href="<?= Url::to(['/post/view', 'id' => $model->id]); ?>" role="button">
            <?= Yii::t('app', 'View details'); ?> »
        </a>
    </p>
    <?php } ?>
</div>