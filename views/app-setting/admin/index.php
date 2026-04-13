<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\AppSetting;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'App Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-setting-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> '  . Yii::t('app', 'Create {modelClass}', ['modelClass' => 'App Setting']), 
            ['create'], 
            ['class' => 'btn btn-success']) 
        ?>
        
        <!-- Reset Search Button -->
        <?= Html::a('<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> ' . Yii::t('app', 'Reset Search'), ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'key',
                'format' => ['raw'],
                'value' => function($data) {
                    return Html::a(Html::encode($data['key']), Url::toRoute(['view', 'id' => $data['id']]));  // link to view record
                },
            ],
            'value',
            'default',
            //'type',
            [   // use dropdown listbox for column filter
                'attribute' => 'type',
                'label' => 'Type',
                'format' => ['raw'],
                'value' => function($data) {
                    return AppSetting::getDataTypeLabel($data['type']);
                },
                'filter' => [0 => 'String', 1 => 'Integer', 2 => 'Boolean']
            ],
            //'unit',
            [   // use dropdown listbox for column filter
                'attribute' => 'unit',
                'label' => 'Unit',
                'format' => ['raw'],
                'value' => function($data) {
                    return AppSetting::getUnitLabel($data['unit']);
                },
                'filter' => [0 => 'mm', 1 => 'inches', 2 => 'pixels', 3 => 'count']
            ],
            //'role',
            [   // use dropdown listbox for column filter
                'attribute' => 'role',
                'label' => 'Role',
                'format' => ['raw'],
                'value' => function($data) {
                    return ($data['status'] > 0 ? 
                       '<span class="label label-warning">Admin</span>' : 
                       '<span class="label label-success">Registered</span>');
                },
                'filter' => [0 => 'Admin', 1 => 'Registered',]
            ],
            //'created_at',
            //'updated_at',
            //'status',
            [   // use dropdown listbox for column filter
                'attribute' => 'status',
                'label' => 'Status',
                'format' => ['raw'],
                'value' => function($data) {
                    return ($data['status'] > 0 ? 
                       '<span class="label label-success">Active</span>' : 
                       '<span class="label label-warning">Inactive</span>');
                },
                'filter' => [1 => 'Active', 0 => 'Inactive']
            ],

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {clone}',
                'buttons' => [
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
