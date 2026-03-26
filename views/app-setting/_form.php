<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'default')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        '1' => 'Active',
        '0' => 'Inactive',
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        'String',
        'Integer',
        'Boolean'
    ]) ?>

    <?= $form->field($model, 'unit')->dropDownList([
        'None',
        'mm',
        'inches',
        'pixels',
        'count',
    ]) ?>

    <?= $form->field($model, 'role')->dropDownList([
        'Admin',
        'Registered',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
