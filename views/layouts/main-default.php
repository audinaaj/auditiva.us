<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        //'brandLabel' => Yii::$app->params['appName'],
        'brandLabel' => Yii::$app->params['companyName'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $menuItems = [
        ['label' => 'Home',    'url' => ['/site/index']],
        ['label' => 'About',   'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        
        // Admin menu only
        !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin() ?
            ['label' => 'Admin', 'url' => ['/site/admin'], 
                'items' => [
                    ['label' => 'Users', 'url' => ['user/index']],
                    ['label' => Yii::t('app', 'Encrypt User Password'), 'url' => ['/user/password']],
                    '<li role="presentation" class="divider"></li>',
                    ['label' => Yii::t('app', 'Generate Models/Controllers/CRUD (Gii)'), 'url' => ['/gii']],
                ]] : 
            '',
    ];
    
    if (Yii::$app->user->isGuest) {
        if (Yii::$app->params['isSignupAllowed']) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/user/signup']];
        }
        $menuItems[] = ['label' => Yii::t('app', 'Login'),  'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => Yii::t('app', 'User ({username})', ['username' => Yii::$app->user->identity->username]), 'url' => ['/site/login'],
            'items' => [
                ['label' => Yii::t('app', 'User Profile'), 'url' => ['user/view', 'id'=>Yii::$app->user->getId()]],
                '<li role="presentation" class="divider"></li>',     // divider
                ['label' => Yii::t('app', 'Logout ({username})', ['username' => Yii::$app->user->identity->username]), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
            ]
        ];
    }
    
    echo Nav::widget([
        'options'      => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,  // false, to allow icons in labels
        'items'        => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?>,  <?= Yii::$app->params['companyName'] ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
