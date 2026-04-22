<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use himiklab\yii2\recaptcha\ReCaptcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = Yii::t('app', 'Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>Please fill out the following fields to signup:</p>
    
    
    <div class="col-lg-12">
        <div class="alert alert-info" role="alert">
        To better serve our users, we require you to provide complete information on this signup page. 
        <?php if (Yii::$app->params['isSignupApprovalRequired']): ?>
            On receipt of your registration, one of our account managers will contact you within 2 business days. 
        <?php endif; ?>
        Sign up as a user to get exclusive access to information. 
        We will protect ALL collected information and will not share your information with any other company or individual.
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
          <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="col-lg-4">
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'phone') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'verifyCode')->widget(ReCaptcha::class)->label(false); ?>
                
            </div>
            <div class="form-group col-lg-12">
                <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
          <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
