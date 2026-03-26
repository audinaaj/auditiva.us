<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\AppSetting;

/* @var $this yii\web\View */
/* @var $model app\models\AppSetting */

$this->title = "[{$model->id}] {$model->key}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'App Settings'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-setting-view">

    <?= \app\widgets\Alert::widget() ?>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> '  . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> '  . Yii::t('app', 'Add'), ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-clone" aria-hidden="true"></i> ' . Yii::t('app', 'Clone'), ['clone', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'key',
            'value',
            'default',
            //'type',
            [
                'label' => 'Type',
                'format' => 'html',
                'value' => $model->getDataTypeLabel($model->type)
            ],
            //'unit',
            [
                'label' => 'Unit',
                'format' => 'html',
                'value' => $model->getUnitLabel($model->unit)
            ],
            //'role',
            [
                'label' => 'Role',
                'format' => 'html',
                'value' => ($model->role > 0 ? '<span class="label label-success">Registered</span>' : '<span class="label label-warning">Admin</span>')
            ],
            'created_at:datetime',
            'updated_at:datetime',
            //'status',
            [
                'label' => 'Status',
                'format' => 'html',
                'value' => ($model->status > 0 ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>')
            ],
        ],
    ]) ?>

</div>


