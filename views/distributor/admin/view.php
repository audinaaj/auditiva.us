<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Distributor */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Distributors'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributor-view">

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
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-clone" aria-hidden="true"></i> ' . Yii::t('app', 'Clone'),  ['clone',  'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'company_name',
            'address',
            'city',
            'state_prov',
            'postal_code',
            'country',
            'latitude',
            'longitude',
            'phone',
            'fax',
            'email:email',
            'website:url',
            'services',
            'dist_country',

            'first_name',
            'last_name',
            'name_prefix',
            'occupation',

            'hours:ntext',
            'instructions:ntext',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => ($model->status > 0 ? 'Published' : 'Unpublished')
            ],
            'created_at',
            'updated_at',
            [
                'attribute' => 'created_by',
                'label' => 'Created by',
                //'value' => $model->createdByUser->username,
                //'value' => print_r($model->createdByUser, true),
                'value' => ($model->createdByUser !== null ? $model->createdByUser->username : 'N/A'),
            ],
            [
                'attribute' => 'updated_by',
                'label' => 'Updated by',
                //'value' => $model->updatedByUser->username,
                //'value' => print_r($model->updatedByUser, true),
                'value' => ($model->updatedByUser !== null ? $model->updatedByUser->username : 'N/A'),
            ],
        ],
    ]) ?>

</div>
