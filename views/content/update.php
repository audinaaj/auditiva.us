<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form ActiveForm */
?>
<div class="content-update">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'category_id') ?>
        <?= $form->field($model, 'hits') ?>
        <?= $form->field($model, 'rating_sum') ?>
        <?= $form->field($model, 'rating_count') ?>
        <?= $form->field($model, 'show_title') ?>
        <?= $form->field($model, 'show_intro') ?>
        <?= $form->field($model, 'show_image') ?>
        <?= $form->field($model, 'show_hits') ?>
        <?= $form->field($model, 'show_rating') ?>
        <?= $form->field($model, 'content_type_id') ?>
        <?= $form->field($model, 'featured') ?>
        <?= $form->field($model, 'ordering') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'created_by') ?>
        <?= $form->field($model, 'updated_by') ?>
        <?= $form->field($model, 'intro_text') ?>
        <?= $form->field($model, 'full_text') ?>
        <?= $form->field($model, 'publish_up') ?>
        <?= $form->field($model, 'publish_down') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'tags') ?>
        <?= $form->field($model, 'intro_image') ?>
        <?= $form->field($model, 'intro_image_float') ?>
        <?= $form->field($model, 'main_image') ?>
        <?= $form->field($model, 'main_image_float') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- content-index -->
