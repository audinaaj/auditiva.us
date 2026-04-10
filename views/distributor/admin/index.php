<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistributorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Distributors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributor-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Distributor',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> ' . Yii::t('app', 'Reset Search'), ['admin-index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'first_name',
            //'last_name',
            //'name_prefix',
            //'occupation',
            //'company_name',
            [   // Use 'company_name' as link to view record 
                'attribute' => 'company_name',
                'format' => ['raw'],
                'value' => function($data) {
                    return Html::a(
                        Html::encode($data['company_name']), 
                        Url::toRoute(['view', 'id' => $data['id']])   
                    );  
                },
            ],
            // 'address',
            'city',
            //'state_prov',
            // 'postal_code',
            'country',
            'dist_country',
            // 'latitude',
            // 'longitude',
            //'phone',
            // 'fax',
            'email:email',
            //'website:url',
            // 'services',
            // 'hours:ntext',
            // 'instructions:ntext',
            // 'status',
            [   // use dropdown listbox for column filter
                'attribute' => 'status',
                'label' => 'Status',
                'format' => ['raw'],
                'value' => function($data) {
                    return ($data['status'] > 0 ? 
                       '<span class="label label-success">Active</span>' : 
                       '<span class="label label-warning">Disabled</span>');
                },
                'filter' => [1 => 'Active', 0 => 'Disabled']
            ],
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [  // custom actions
               'class'    => 'yii\grid\ActionColumn', 
               'template' => '{view} {update} {delete} {clone}', /* '{view} {update} {delete}' */
               'buttons'  => [
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
