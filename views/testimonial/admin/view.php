<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Testimonial */

$this->title = "Testimonial [{$model->id}] from {$model->author}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testimonials'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testimonial-view">

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
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> '  . Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-clone" aria-hidden="true"></i> ' . Yii::t('app', 'Clone'), ['clone', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'comment',
            'author',
            'location',
            'tags',
            [
                'label' => 'Status',
                'format' => 'html',
                'value' => ($model->status > 0 ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>')
            ],
        ],
    ]) ?>

</div>
