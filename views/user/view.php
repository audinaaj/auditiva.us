<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = "{$model->first_name} {$model->last_name} ({$model->username})";
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
} else {
    $this->params['breadcrumbs'][] = Yii::t('app', 'Users');
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
            // echo Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            //     'class' => 'btn btn-danger',
            //     'data' => [
            //         'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            //         'method' => 'post',
            //     ],
            // ]);
        ?>
    </p>

    <div class="col-md-4">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'password_hash',
            //'password_reset_token',
            //'auth_key',
            //'access_token',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            //'company_name',
            //'job_title',
            //'account_number',
        ],
    ]) ?>
    </div>
    
    <div class="col-md-4">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'address1',
            //'address2',
            //'city',
            //'state_prov',
            //'postal_code',
            //'country',
            'avatar',
            //'role',
            [
                'label'  => 'Role',
                'format' => 'html',
                'value'  => app\models\User::getRoleLabel($model->role),
            ],
        ],
    ]) ?>
    </div>
    
    <div class="col-md-4">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'status',
            [
                'label'  => 'Status',
                'format' => ['raw'],
                'value'  => app\models\User::getStatusLabel($model->status)
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'last_login:datetime',
        ],
    ]) ?>
    </div>

</div>
