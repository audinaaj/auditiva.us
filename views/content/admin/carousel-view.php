<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\web\User;
//use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Carousel'), 'url' => ['carousel-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> '  . Yii::t('app', 'Update'), ['carousel-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php //echo Html::a('<i class="fa fa-plus" aria-hidden="true"></i> '  . Yii::t('app', 'Add'),   ['carousel-create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-clone" aria-hidden="true"></i> ' . Yii::t('app', 'Clone'), ['carousel-clone', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?php
        $carousel_content = Html::img(Yii::$app->formatter->asS3Url($model['intro_image']));
        if (!empty($model['full_text'])) {
            $carousel_content = Html::a($carousel_content, $model['full_text']);
        }

        echo yii\bootstrap\Carousel::widget([
            'items' => [['content' => $carousel_content]],
            'showIndicators' => true,
            //'controls' => ['&lsaquo;', '&rsaquo;'],
            'controls' => [
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', 
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
            ],
        ]);
    ?>
    <br/>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width: 150px">{label}</th><td>{value}</td></tr>',  // row template
        'attributes' => [
            // 'id',
            //'title',
            'intro_image:text:Image',
            'full_text:url:Link Target',
            // [
            //     'attribute' => 'full_text',
            //     'label' => 'Link Target',
            //     'value' => $model->full_text//Url::toRoute($model->full_text)
            // ],
            //'ordering',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => ($model->status > 0 ? 'Published' : 'Unpublished')
            ],
            'publish_up:date',
            'publish_down:date',
            [
                'attribute' => 'created_by',
                'label' => 'Created by',
                //'value' => $model->createdByUser->username,
                //'value' => print_r($model->createdByUser, true),
                'value' => ($model->createdByUser !== null ? $model->createdByUser->username : 'N/A'),
            ],
            'created_at:date',
            [
                'attribute' => 'updated_by',
                'label' => 'Updated by',
                //'value' => $model->updatedByUser->username,
                //'value' => print_r($model->updatedByUser, true),
                'value' => ($model->updatedByUser !== null ? $model->updatedByUser->username : 'N/A'),
            ],
            'updated_at:date',
        ],
    ]) ?>

</div>
