<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\User;
//use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">
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
        <?= Html::a('<i class="fa fa-clone" aria-hidden="true"></i> ' . Yii::t('app', 'Clone'),  ['clone',  'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="150">{label}</th><td>{value}</td></tr>',  // row template
        'attributes' => [
            'id',
            'title',
            [
                //'attribute' => 'category_id',
                'label' => 'Category',
                'value' => $model->category->title
            ],
            'tags',
            'intro_text:html', 
            'full_text:html',
            'full_text:text:Full Text (Raw HTML)',
            'intro_image',
            [
                'attribute' => 'intro_image',
                'label'     => 'Image',
                'format'    => 'raw',
                'value'     => '<img src="'.(!empty($model->intro_image) ? Yii::$app->formatter->asS3Url($model->intro_image) : '').'" style="width: 700px;"/>'
            ],
            'intro_image_float',
            'main_image',
            [
                'attribute' => 'main_image',
                'value' => (!empty($model->main_image) ? Yii::$app->formatter->asS3Url($model->main_image) : ''),
                'format' => 'image',
            ],
            'main_image_float',
            'hits',
            'rating_sum',
            'rating_count',
            [
                'attribute' => 'show_title',
                'label' => 'Show Title',
                'value' => ($model->show_title > 0 ? 'Yes' : 'No')
            ],
            [
                'attribute' => 'show_intro',
                'label' => 'Show Intro',
                'value' => ($model->show_intro > 0 ? 'Yes' : 'No')
            ],
            [
                'attribute' => 'show_image',
                'label' => 'Show Image',
                'value' => ($model->show_image > 0 ? 'Yes' : 'No')
            ],
            [
                'attribute' => 'show_hits',
                'label' => 'Show Hits',
                'value' => ($model->show_hits > 0 ? 'Yes' : 'No')
            ],
            [
                'attribute' => 'show_rating',
                'label' => 'Show Rating',
                'value' => ($model->show_rating > 0 ? 'Yes' : 'No')
            ],
            [
                //'attribute' => 'content_type_id',
                'label' => 'Content Type',
                'value' => $model->contentType->title
            ],
            [
                'attribute' => 'featured',
                'label' => 'Featured',
                'value' => ($model->featured > 0 ? 'Yes' : 'No')
            ],
            'ordering',
            'publish_up:date',
            'publish_down:date',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => ($model->status > 0 ? 
                    '<span class="label label-success">Published</span>' : 
                    '<span class="label label-warning">Unpublished</span>')
            ],
            'created_at:datetime',
            'updated_at:datetime',
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
