<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var integer $id
 * @var string $login
 */

?>
<p>Зарегистрировался новый пользователь: <?= Html::encode($login); ?>.
    Для просмотра перейдите по <a href="<?= Url::to(['/admin/user/view', 'id' => $id], true); ?>">ссылке</a>.</p>