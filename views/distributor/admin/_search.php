<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DistributorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distributor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'name_prefix') ?>

    <?php // echo $form->field($model, 'occupation') ?>

    <?php echo $form->field($model, 'company_name') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php echo $form->field($model, 'city') ?>

    <?php echo $form->field($model, 'state_prov') ?>

    <?php // echo $form->field($model, 'postal_code') ?>

    <?php echo $form->field($model, 'country') ?>

    <?php echo $form->field($model, 'dist_country') ?>

    <?php // echo $form->field($model, 'latitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

    <?php echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php echo $form->field($model, 'email') ?>

    <?php echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'services') ?>

    <?php // echo $form->field($model, 'hours') ?>

    <?php // echo $form->field($model, 'instructions') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
