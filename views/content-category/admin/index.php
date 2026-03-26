<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContentCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Content Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-category-index">

    <?= \app\widgets\Alert::widget() ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Content Category',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> ' . Yii::t('app', 'Reset Search'), ['admin-index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'alias',
            //'intro_text:ntext',
            //'image',
            // 'image_float',
            // 'show_title',
            // 'show_intro',
            // 'show_image',
            'ordering',
            // 'published',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
