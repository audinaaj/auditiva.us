<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AppSetting */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'App Setting',
]) . ' ' . "[{$model->id}] {$model->key}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'App Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "[{$model->id}] {$model->key}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="app-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
