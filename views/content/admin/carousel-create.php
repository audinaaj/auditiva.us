<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = Yii::t('app', 'Create Carousel');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Carousel'), 'url' => ['carousel-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('carousel-form', [
        'model' => $model,
    ]) ?>

</div>
