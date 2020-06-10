<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'state_prov')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-md-4">
                <?= $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                
                <?php $model->payment_date = ($model->isNewRecord ? date("Y-m-d") : $model->payment_date); ?>
                <?= $form->field($model, 'payment_date')->widget(DatePicker::classname(), [
                       'language' => 'en',
                       'clientOptions' => [
                          'defaultDate' => '01-01-2014', 
                          'dateFormat' => 'MM-dd-yyyy'
                       ],
                       'options'=> ['class'=>'form-control'],  // Bootstrap theme
                   ])->textInput(['placeholder' => 'YYYY-MM-DD'])->label('Payment Date') ?>

                <?= $form->field($model, 'payment_status')->dropDownList(
                    ['0'=>'Unpaid', '1'=>'Paid']
                ) ?>
            
                <?= $form->field($model, 'crcard_type')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'crcard_number')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'crcard_first_name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'crcard_last_name')->textInput(['maxlength' => true]) ?>
            </div>
            
            <div class="col-md-4">
                <?= $form->field($model, 'trans_id')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?= $form->field($model, 'trans_invoice_num')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?= $form->field($model, 'trans_description')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?= $form->field($model, 'trans_response')->textarea(['rows' => 6, 'readonly' => true]) ?>
                <?= $form->field($model, 'ip_address')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'active')->dropDownList(
                    ['1'=>'Yes', '0'=>'No']
                ) ?>
            </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
