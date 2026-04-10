<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\UtilsProvider;
use himiklab\yii2\recaptcha\ReCaptcha;

/* @var $this yii\web\View */
$this->title = 'Find a Professional';
$this->params['breadcrumbs'][] = ['label'=> 'Consumers', 'url' => Url::toRoute(['consumer/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>

<div class="consumer-find-professional">
    <h1><?= Html::encode($this->title) ?></h1>
    <img src="https://cdn.auditiva.us/consumers/banner-find-professional.jpg'" class="img-responsive" align="center" width="1140">

    <p>&nbsp;</p>
    <p>
        If you are trying to find a hearing professional in your area, please fill out the following form to contact us. 
        We will contact you soon after with the details of an authorized hearing professional in your area. Thank you. 
    </p>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="col-lg-7">
                <?= $form->field($model, 'firstName') ?>
                <?= $form->field($model, 'lastName') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'telephone') ?>
                <?= $form->field($model, 'city') ?>
                <?= $form->field($model, 'state')->dropDownList(
                    UtilsProvider::$states,
                    ['prompt'=>'--Select One--']    // options
                ) ?>
                <?= $form->field($model, 'zipCode') ?>
                <?= $form->field($model, 'country')->dropDownList(
                    UtilsProvider::$countryNames,
                    ['prompt'=>'--Select One--']    // options
                ) ?>
            </div>
            <div class="col-lg-5">
                <?= $form->field($model, 'isProductUser')->label('Do you currently wear hearing aids?')->radioList([
                    'yes'=>'Yes',
                    'no'=>'No'
                ]) ?>
                <?= $form->field($model, 'productInterests')->label('What are the products in which you are interested in? <br/>(choose all that apply)')->checkBoxList([
                    'Hearing Aids'=>'Hearing Aids',
                    'Bluetooth'=>'Bluetooth®',
                    'Other'=>'Other'
                ]) ?>
                <?= $form->field($model, 'helpType')->label('How may we help you?')->radioList([
                    'Need location to repair hearing aid' => 'I am looking for a location that can repair my hearing instrument.',
                    'Need location to purchase hearing aid / accessory' => 'I am looking for a location where I can purchase an '. Yii::$app->params['companyNameShort'] . ' hearing instrument or accessory.'
                ]) ?>
                <?= $form->field($model, 'productSerialNumbers')->label('Product Serial Numbers (if available)') ?>
                
                <?php 
                    // Regenerate new captcha after each refresh.
                    $this->context->createAction('captcha')->getVerifyCode(true); 
                    echo $form->field($model, 'verifyCode')->widget(ReCaptcha::class)->label(false);
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
