<?php
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use himiklab\yii2\recaptcha\ReCaptcha;

use app\models\UtilsProvider;

/* @var $this yii\web\View */
$this->title = 'Contact Us';
//$this->params['breadcrumbs'][] = ['label'=> 'Site', 'url' => Url::toRoute(['site/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>

<div class="site-contact-us">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>&nbsp;</p>
    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
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
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'helpCategory')->label('Category')->dropDownList([
                    "General Information / Product Questions" => "General Information / Product Questions",
                    "Product Support / Troubleshooting" => "Product Support / Troubleshooting",
                    "Repair / Service Location" => "Repair / Service Location",
                    "Product or Accessory Retail Location" => "Product or Accessory Retail Location",
                    "Other" => "Other",
                ]) ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>                
                <?= $form->field($model, 'productSerialNumbers')->label('Product Serial Numbers (if available)') ?>
                <?php 
                    // To regenerate new captcha after each refresh, call getVerifyCode(). 
                    // See: http://www.yiiframework.com/forum/index.php/topic/17638-captcha-code-not-changing/.
                    $this->context->createAction('captcha')->getVerifyCode(true); 
                ?>
                
                <?php 
                    // Using default Yii2 captcha field
                    //echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    //    'captchaAction' => 'site/captcha',  // redirect to correct controller where captcha is defined
                    //    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    //]) 
                ?>
                <?= $form->field($model, 'verifyCode')->widget(ReCaptcha::classname())->label(false); ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php
// Simulate a click on "refresh captcha" for GET requests
//if (!Yii::$app->request->isPost) {
//    $this->registerJS(
//        //'init',
//        '$(".captcha a").trigger("click");',
//        \yii\web\View::POS_READY
//    );
//}
?>    