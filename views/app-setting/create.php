<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AppSetting */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'App Setting',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'App Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
