<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ContentType */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Content Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content Types'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
