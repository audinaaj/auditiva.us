<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distributor */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Distributor',
]) . ' ' . $model->company_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="distributor-update">

    <?= \app\widgets\Alert::widget() ?>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
