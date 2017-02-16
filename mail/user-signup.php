<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

use yii\helpers\Url;

/**
 * @var string $login
 * @var string $code
 */

?>
<p>Для завершения регистрации перейдите по <a href="<?= Url::to(['/site/confirm', 'code' => $code, 'login' => $login], true); ?>">ссылке</a>.</p>