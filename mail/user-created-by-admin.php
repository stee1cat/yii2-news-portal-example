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
<p>Вы зарегистрированы. Для завершения перейдите по <a href="<?= Url::to(['/site/reset-password', 'code' => $code, 'login' => $login], true); ?>">ссылке</a>.</p>