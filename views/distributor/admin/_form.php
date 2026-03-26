<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UtilsProvider;

/* @var $this yii\web\View */
/* @var $model app\models\Distributor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distributor-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Company Information</h3></div>
            <div class="panel-body">
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'state_prov')->dropDownList(
                    UtilsProvider::$states,
                    [ 'prompt' => '--Select One--' ]
                ) ?>
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'country')->dropDownList(
                    UtilsProvider::$countryNames,
                    [ 'prompt' => '--Select One--' ]
                ) ?>

            <?= $form->field($model, 'latitude')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'longitude')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'fax')->textInput(['maxlength' => 50]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'services')->dropDownList([
                    'Headquarters'           => 'Headquarters', 
                    'Factory '               => 'Factory', 
                    'Main Distributor'       => 'Main Distributor', 
                    'Authorized Distributor' => 'Authorized Distributor', 
                    'Distributor'            => 'Distributor', 
                    'Laboratory'             => 'Laboratory', 
                    'Audiologist'            => 'Audiologist', 
                    'Dispenser'              => 'Dispenser', 
                    'Other'                  => 'Other'
                ]
                //['prompt'=>'--Select One--']    // options
            ) ?>

            <?= $form->field($model, 'dist_country')->dropDownList(
                    UtilsProvider::$countryNames,
                    [ 'prompt' => '--Select One--' ]
                ) ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Contact Person</h3></div>
            <div class="panel-body">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'name_prefix')->dropDownList(
                        ['Mr'=>'Mr', 
                         'Mrs'=>'Mrs', 
                         'Ms'=>'Ms', 
                         'Dr'=>'Dr', 
                         'Other'=>'Other']
                        //['prompt'=>'--Select One--']    // options
                    ) ?>

            <?= $form->field($model, 'occupation')->textInput(['maxlength' => 255]) ?>
            </div>
        </div>
    </div>
    
    
    <div class="col-md-12">
    <?= $form->field($model, 'hours')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'instructions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ['1'=>'Published', '0'=>'Unpublished']
        //['prompt'=>'--Select One--']    // options
    ); ?>

    <?= Html::errorSummary($model, ['class' => 'errors']) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>
    
    </div>

    <?php ActiveForm::end(); ?>

</div>
