<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\ContentCategory;
use app\models\ContentType;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '"Message of the Day" List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;

date_default_timezone_set('America/New_York');
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Create "Message of the Day"'), ['motd-create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> ' . Yii::t('app', 'Reset Search'), ['admin-index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'title',
                'format' => ['raw'],
                'value' => function($data) {
                    return Html::a(Html::encode($data['title']), Url::toRoute(['motd-view', 'id' => $data['id']]));  // link to view record
                },
                'enableSorting' => true,
            ],
            //'category_id',
            //[
            //    'attribute'=>'category',
            //    'value'=>'category.title',
            //],
            [
                'attribute'=>'category_id',
                'label' => 'Category',
                'format' => ['raw'],
                'value' => function($model) {
                    return $model->category->title;
                },
                'filter' => ArrayHelper::map(ContentCategory::find()->all(), 'id', 'title'),
            ],
            'tags',
            //'intro_text:ntext',
            //'full_text:ntext',
            //'intro_image',
            //'intro_image_float',
            //'main_image',
            //'main_image_float',
            //'hits',
            //'rating_sum',
            //'rating_count',
            //'show_title',
            //'show_intro',
            //'show_image',
            //'show_hits',
            //'show_rating',
            //'content_type_id',
            //[
            //    'attribute'=>'content_type_id',
            //    'label' => 'Type',
            //    'format' => ['raw'],
            //    'value' => function($model) {
            //        return $model->contentType->title;
            //    },
            //    'filter' => ArrayHelper::map(ContentType::find()->all(), 'id', 'title'),
            //],
            //'featured',
            //[
            //    'attribute' => 'featured',
            //    'label' => 'Featured',
            //    'format' => ['raw'],
            //    'value' => function($data) {
            //        return ($data['featured'] > 0 ? 'Yes' : 'No');
            //    },
            //    'filter' => [0 => 'No', 1 => 'Yes']
            //],
            //'ordering',
            'publish_up:date',
            'publish_down:date',
            // 'status',
            // 'created_by',
            'created_at:datetime',
            // 'updated_by',
            'updated_at:datetime',
            
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => ['raw'],
                'value' => function($data) {
                    return ($data['status'] > 0 ? '<i class="glyphicon glyphicon-check d-icon"></i>' : '<i class="glyphicon glyphicon-unchecked d-icon"></i>');
                },
                'filter' => [0 => 'Unpublished', 1 => 'Published']
            ],

            [
                'class'    => 'yii\grid\ActionColumn', 
                'template' => '{view} {update} {delete} {clone}',
                'buttons' => [
                    'view'     => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open d-icon"></i>', 
                          Url::toRoute(['motd-view', 'id' => $model['id']]));  // link to view record
                    },
                    'update'   => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-pencil d-icon"></i>', 
                          Url::toRoute(['motd-update', 'id' => $model['id']]));  // link to update record
                    },
                    'clone' => function ($url, $model, $key) {
                       return Html::a('<i class="fa fa-clone" aria-hidden="true"></i>',
                           Url::toRoute(['motd-clone', 'id' => $model['id']])  // clone record
                       );  
                    },
                ],
            ],
        ],
    ]); ?>

</div>
