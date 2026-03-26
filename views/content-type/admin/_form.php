<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'published')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
