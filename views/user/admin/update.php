<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Update User: {nameAttribute}', [
    'nameAttribute' => "{$model->first_name} {$model->last_name} ({$model->username})",
]);
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['admin-index']];
} else {
    $this->params['breadcrumbs'][] = Yii::t('app', 'Users');
}
$this->params['breadcrumbs'][] = ['label' => "{$model->first_name} {$model->last_name} ({$model->username})", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <?= \app\widgets\Alert::widget() ?>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
