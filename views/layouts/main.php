<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\rbac\Roles;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Breaking News',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $items = [
        [
            'label' => Yii::t('app', 'Control Panel'),
            'items' => [
                [
                    'label' => Yii::t('app', 'Posts'),
                    'url' => '/admin/post',
                    'visible' => Yii::$app->user->can(Roles::MODERATOR),
                ],
                [
                    'label' => Yii::t('app', 'Уведомления'),
                    'url' => '/admin/notification',
                    'visible' => Yii::$app->user->can(Roles::ADMIN),
                ],
                [
                    'label' => Yii::t('app', 'Users'),
                    'url' => '/admin/user',
                    'visible' => Yii::$app->user->can(Roles::ADMIN),
                ],
            ],
            'visible' => Yii::$app->user->can(Roles::MODERATOR),
        ],
        [
            'label' => Yii::t('app', 'Profile'),
            'items' => [
                [
                    'label' => Yii::t('app', 'Settings'),
                    'url' => '/profile',
                ],
                [
                    'label' => Yii::t('app', 'Notifications'),
                    'url' => '/profile/notification',
                ],
                [
                    'label' => Yii::t('app', 'Change Password'),
                    'url' => '/profile/change-password',
                ],
            ],
            'visible' => Yii::$app->user->can(Roles::USER),
        ],
    ];

    if (Yii::$app->user->isGuest) {
        $items = array_merge($items, [
            ['label' => Yii::t('app', 'Sign Up'), 'url' => ['/site/signup']],
            ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']],
        ]);
    }
    else {
        $items = array_merge($items, [(
            '<li class="notification-popover">'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(sprintf('%s (%s)', Yii::t('app', 'Logout'), Yii::$app->user->identity->login), [
                'class' => 'btn btn-link logout',
            ])
            . Html::endForm()
            . '</li>'
        )]);
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
    <script>
        var siteConfig = {
            logged: <?= Yii::$app->user->isGuest ? 0 : 1; ?>
        };
    </script>
<?php $this->endBody() ?>
    <script src="/js/script.js"></script>
</body>
</html>
<?php $this->endPage() ?>
