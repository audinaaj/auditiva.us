<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'tags') ?>

    <?= $form->field($model, 'intro_text') ?>

    <?php // echo $form->field($model, 'full_text') ?>

    <?php // echo $form->field($model, 'intro_image') ?>

    <?php // echo $form->field($model, 'intro_image_float') ?>

    <?php // echo $form->field($model, 'main_image') ?>

    <?php // echo $form->field($model, 'main_image_float') ?>

    <?php // echo $form->field($model, 'hits') ?>

    <?php // echo $form->field($model, 'rating_sum') ?>

    <?php // echo $form->field($model, 'rating_count') ?>

    <?php // echo $form->field($model, 'show_title') ?>

    <?php // echo $form->field($model, 'show_intro') ?>

    <?php // echo $form->field($model, 'show_image') ?>

    <?php // echo $form->field($model, 'show_hits') ?>

    <?php // echo $form->field($model, 'show_rating') ?>

    <?php // echo $form->field($model, 'content_type_id') ?>

    <?php // echo $form->field($model, 'featured') ?>

    <?php // echo $form->field($model, 'ordering') ?>

    <?php // echo $form->field($model, 'publish_up') ?>

    <?php // echo $form->field($model, 'publish_down') ?>

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
