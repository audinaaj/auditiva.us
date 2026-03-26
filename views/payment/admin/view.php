<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'full_name',
            'company_name',
            'address',
            'city',
            'state_prov',
            'postal_code',
            'country',
            'email:email',
            'phone',
            'fax',
            'account_number',
            'amount',
            'description',
            'payment_date',
            'payment_status',
            'crcard_type',
            'crcard_number',
            'crcard_first_name',
            'crcard_last_name',
            'trans_id',
            'trans_invoice_num',
            'trans_description',
            'trans_response:ntext',
            'ip_address',
            'notes:ntext',
            'created_at',
            'updated_at',
            'active',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
