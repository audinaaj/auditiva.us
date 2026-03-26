<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        
        <div class="form-group">
            <div class="col-md-offset-1 col-md-11" style="color:#999;">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <p>
        By logging in you are consenting to our use of cookies in accordance with our <?=Html::a("privacy policy", ['site/privacy'])?>.
    </p>

    <p style="color:#999;">
        Forgot your password? <?= Html::a(Yii::t('app', 'Reset Password'), ['user/request-password-reset']) ?>. <br>
        Don't have an account? <?= Html::a(Yii::t('app', 'Signup'), ['user/signup']) ?>.
    </p>

</div>
