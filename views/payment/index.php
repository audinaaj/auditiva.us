<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', "Payments for: {user}", ["user" => Yii::$app->user->identity->full_name]);
if (Yii::$app->user->identity->isAdmin()) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['payment/admin-index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <?= \app\widgets\Alert::widget() ?>
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Payment'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Reset Search'), ['index', 'owner_id' => Yii::$app->user->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'full_name',
            //'company_name',
            // 'address',
            //'city',
            //'state_prov',
            //'postal_code',
            //'country',
            // 'email:email',
            // 'phone',
            // 'fax',
            // 'account_number',
            'payment_date:date',
            'description',
            'amount:currency',
            // 'payment_status',
            // 'crcard_type',
            // 'crcard_number',
            // 'crcard_first_name',
            // 'crcard_last_name',
            // 'trans_id',
            // 'trans_invoice_num',
            // 'trans_description',
            // 'trans_response:ntext',
            // 'ip_address',
            // 'notes:ntext',
            // 'created_at',
            // 'updated_at',
            // 'active',
            // 'created_by',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
