<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Distributor */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Distributor',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
