<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */


$this->title = "Payment";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['user/view', 'id'=>Yii::$app->user->getId()]];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Account Payment";

$curYear = intval(date("Y"));
$years = [];
for($year=$curYear; $year <= ($curYear+10); $year++) {
    $years[] = ["id" => substr($year, 2, 2), "name" => $year];
}

$months = [
    ["id" => "01", "name" => "01 - January"],
    ["id" => "02", "name" => "02 - February"],
    ["id" => "03", "name" => "03 - March"],
    ["id" => "04", "name" => "04 - April"],
    ["id" => "05", "name" => "05 - May"],
    ["id" => "06", "name" => "06 - June"],
    ["id" => "07", "name" => "07 - July"],
    ["id" => "08", "name" => "08 - August"],
    ["id" => "09", "name" => "09 - September"],
    ["id" => "10", "name" => "10 - October"],
    ["id" => "11", "name" => "11 - November"],
    ["id" => "12", "name" => "12 - December"],
];

// ----------------------------------------------
// Sandbox Test Credit Card Numbers
// ----------------------------------------------
// Card Type                    Card Number
// ----------------------------------------------
// American Express Test Card   370000000000002
// Discover Test Card           6011000000000012
// Visa Test Card               4007000000027
// Second Visa Test Card        4012888818888
// JCB                          3088000000000017
// Diners Club/ Carte Blanche   38000000000006
// 
// Set the expiration date to anytime in the future.
// ----------------------------------------------
// Live Test Credit Card Numbers
// ----------------------------------------------
// Card Type                    Card Number
// ----------------------------------------------
// Visa Test Card               4111111111111111
// ----------------------------------------------
if (Yii::$app->params["authorizenetTestMode"]) {
    // Pre-populate with test values
    $model->crcard_type             = "Visa";
    if (Yii::$app->params["authorizenetSandbox"]) {
        $model->crcard_plain_number = "4007000000027";    // sandbox Visa CC test number_format
    } else {
        $model->crcard_plain_number = "4111111111111111";  // live Visa CC test number_format
    }
    $model->crcard_security_code    = "1234";
    $model->crcard_expiration_month = "12";
    $model->crcard_expiration_year  = substr(intval(date('Y'))+3, 2, 2);
}

?>

<div class="payment-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'readonly' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'state_prov')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
            
            <?php if (Yii::$app->params["authorizenetTestMode"] || Yii::$app->params["authorizenetSandbox"]): ?>
                <div class="alert alert-danger" role="alert">
                    Credit Card Payment System is in Test Mode
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-5">
            <div class="panel panel-info">
                <div class="panel-heading">Credit Card</div>
                <div class="panel-body">
                    <div class="col-md-4"><?= $form->field($model, 'amount')->textInput(['value' => $amount, 'maxlength' => true, 'placeholder' => '$']) ?></div>
                    <div class="col-md-8">
                        <?php $model->description = ($model->isNewRecord ? "Pmt for Account {$model->account_number}" : $model->description); ?>
                        <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                    </div>
                    <div class="col-md-12">
                    <?= $form->field($model, 'crcard_type')->dropDownList(
                        ['MasterCard'=>'MasterCard', 'Visa'=>'Visa', 'AMEX'=>'AmericanExpress', 'Discover'=>'Discover'],
                        ['prompt'=>'--Select One--']    // options
                    )->label('Type') ?>
                    </div>

                    <div class="col-md-6"> 
                        <?= $form->field($model, 'crcard_expiration_month')->dropDownList(
                            \yii\helpers\ArrayHelper::map($months, 'id', 'name'),
                            ['prompt'=>'--Select One--']    // options
                        )->label('Expiration Month') ?>
                    </div>
                    
                    <div class="col-md-6"> 
                        <?= $form->field($model, 'crcard_expiration_year')->dropDownList(
                            \yii\helpers\ArrayHelper::map($years, 'id', 'name'),
                            ['prompt'=>'--Select One--']    // options
                        )->label('Expiration Year') ?>
                    </div>
                    
                    <div class="col-md-6"><?= $form->field($model, 'crcard_plain_number')->textInput(['maxlength' => true, 'placeholder' => 'XXXXXXXXXXXXXXXX'])->label('Number') ?></div>
                    <div class="col-md-6"><?= $form->field($model, 'crcard_security_code')->textInput(['maxlength' => true, 'placeholder' => 'XXXX'])->label('Security Code') ?></div>
                    <div class="col-md-6"><?= $form->field($model, 'crcard_first_name')->textInput(['maxlength' => true])->label('First Name') ?></div>
                    <div class="col-md-6"><?= $form->field($model, 'crcard_last_name')->textInput(['maxlength' => true])->label('Last Name') ?></div>
                </div>
            </div>
        </div>
        
        
    </div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Submit') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
