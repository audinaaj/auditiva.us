<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> ' . Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-erase" aria-hidden="true"></span> ' . Yii::t('app', 'Reset Search'), ['admin-index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'filterRowOptions' => ['class' => 'filters', 'id' => 'flt'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'username',
            [   // Use 'username' as link to view record 
                'attribute' => 'username',
                'format' => ['raw'],
                'value' => function($data) {
                    return Html::a(
                        "<b>".Html::encode($data['username'])."</b>", 
                        ['view', 'id' => $data['id']]
                    );  
                },
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'user-username'],
            ],
            //'password_hash',
            //'password_reset_token',
            //'auth_key',
            //'access_token',
            'first_name',
            'last_name',
            'phone',
            'email:email',
            //'avatar',
            //'role',
            [    // use dropdown listbox for colum filter, using data from model
                'attribute'=>'role',
                'format' => ['raw'],
                'value' => function($data) {
                    return app\models\User::getRoleLabel($data->role);
                },
                //'filter' => ArrayHelper::map(User::getRoles, 'id', 'role'),
                'filter' => app\models\User::getRoles(),
            ],
            //'status',
            [    // use dropdown listbox for colum filter, using data from model
                'attribute'=>'status',
                'format' => ['raw'],
                'value' => function($data) {
                    return app\models\User::getStatusLabel($data->status);
                },
                'filter' => app\models\User::getStatuses(),
            ],
            'created_at',
            //'updated_at',
            'last_login',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
