<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'intro_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'image_float')->dropDownList(
                ['left'=>'Left', 'right'=>'Right', 'center'=>'Center']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_title')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_intro')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_image')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?php for($i=0, $order=array(); $i<=100; $i++) { $order[] = $i; } ?>
    <?= $form->field($model, 'ordering')->dropDownList($order) ?>

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
