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

$this->title = Yii::t('app', 'Contents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;

date_default_timezone_set('America/New_York');
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Content',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
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
                    return Html::a(Html::encode($data['title']), Url::toRoute(['view', 'id' => $data['id']]));  // link to view record
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
            // 'full_text:ntext',
            // 'intro_image',
            // 'intro_image_float',
            // 'main_image',
            // 'main_image_float',
            // 'hits',
            // 'rating_sum',
            // 'rating_count',
            // 'show_title',
            // 'show_intro',
            // 'show_image',
            // 'show_hits',
            // 'show_rating',
            // 'content_type_id',
            [
                'attribute'=>'content_type_id',
                'label' => 'Type',
                'format' => ['raw'],
                'value' => function($model) {
                    return $model->contentType->title;
                },
                'filter' => ArrayHelper::map(ContentType::find()->all(), 'id', 'title'),
            ],
            //'featured',
            [
                'attribute' => 'featured',
                'label' => 'Featured',
                'format' => ['raw'],
                'value' => function($data) {
                    return ($data['featured'] > 0 ? 'Yes' : 'No');
                },
                'filter' => [0 => 'No', 1 => 'Yes']
            ],
            'ordering',
            'publish_up',
            'publish_down',
            // 'status',
            // 'created_by',
            'created_at:datetime',
            // 'updated_by',
            'updated_at:datetime',

            //['class' => 'yii\grid\ActionColumn'],
            [  // custom actions
               'class'    => 'yii\grid\ActionColumn', 
               'template' => '{view} {update} {delete} {clone}',
               'buttons' => [
                   // custom action Clone
                   'clone' => function ($url, $model, $key) {
                       return Html::a('<i class="fa fa-clone" aria-hidden="true"></i>',
                           yii\helpers\Url::toRoute(['clone', 'id' => $model['id']])  // clone record
                       );  
                   },
               ],
            ],
        ],
    ]); ?>

</div>
