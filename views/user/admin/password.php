<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\PasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Password Encryption';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['user/admin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-password">
    <?php if (!empty($encrypted_password)) : ?>
        <div class="alert alert-success" role="alert"><strong>Encrypted Password:</strong><pre><?= $encrypted_password ?></pre></div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Enter a password to encrypt:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Encrypt', ['class' => 'btn btn-primary', 'name' => 'encrypt-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
