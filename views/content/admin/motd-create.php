<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = Yii::t('app', 'Create "Message of the Day"');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Message of the Day'), 'url' => ['motd-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('motd-form', [
        'model' => $model,
    ]) ?>

</div>
