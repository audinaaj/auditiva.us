<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\UtilsProvider;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= ($model->isNewRecord || (Yii::$app->user->identity->isAdmin())? $form->field($model, 'username')->textInput(['maxlength' => true]) : $form->field($model, 'username')->textInput(['readonly'=> true])) ?>
    
    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->passwordInput() ?>
    
    <?= ($model->isNewRecord || (Yii::$app->user->identity->isAdmin())? $form->field($model, 'access_token')->textInput(['maxlength' => true]) : $form->field($model, 'access_token')->textInput(['readonly'=> true])) ?>
    
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
      
    <?php //echo $form->field($model, 'address1')->textInput(['maxlength' => true]) ?>
      
    <?php //echo $form->field($model, 'address2')->textInput(['maxlength' => true]) ?>
      
    <?php //echo $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
      
    <?php 
    //echo $form->field($model, 'state_prov')->textInput(['maxlength' => true])->dropDownList(
    //    \app\models\UtilsProvider::$states,
    //    [ 'prompt' => '--Select One--' ]
    //);
    ?>

    <?php //echo $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <?php
    //echo $form->field($model, 'country')->textInput(['maxlength' => true])->dropDownList(
    //    \app\models\UtilsProvider::$countryNames,
    //    [ 'prompt' => '--Select One--' ]
    //);
    ?>

    <?php 
    //echo $form->field($model, 'job_title')->textInput(['maxlength' => true])->dropDownList(
    //    ['Owner'=>'Owner', 'Office Manager'=>'Office Manager', 'Employee'=>'Employee', 'Other'=>'Other'],
    //    ['prompt'=>'--Select One--']    // options
    //); 
    ?>

    <?php //echo $form->field($model, 'account_number')->textInput(['maxlength' => true]) ?>
    
    <?php //echo $form->field($model, 'receive_newsletter')->checkbox() ?> 

    <?= ($model->isNewRecord || (Yii::$app->user->identity->isAdmin())? $form->field($model, 'role')->dropDownList(
        \app\models\User::getRoles(),
        [ 'prompt' => '--Select One--' ]
    ) : $form->field($model, 'role')->dropDownList([$model->role => \app\models\User::getRoleLabel($model->role, false)], ['readonly'=> true]) ) ?>
    

    <?= ($model->isNewRecord || (Yii::$app->user->identity->isAdmin())? $form->field($model, 'status')->dropDownList(
        \app\models\User::getStatuses(),
        [ 'prompt' => '--Select One--' ]
    ) : $form->field($model, 'status')->dropDownList([$model->status => \app\models\User::getStatusLabel($model->status, false)], ['readonly'=> true]) ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
