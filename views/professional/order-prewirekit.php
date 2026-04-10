<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\jui\DatePicker;
use app\models\Tool;
use app\models\OrderItemPrewirekit;

/* @var $this yii\web\View */
$this->title = 'Pre-wire Kit Order';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

// Form data
$arrNumbers = [];
for($i=0; $i<=300; $i++) {
    $arrNumbers[] = $i;
}
?>

<div class="professional-order-prewirekit">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>&nbsp;</p>
    <p>
        To place a Pre-wire Kit order, please fill out the following form. 
        We will contact you soon after for confirmation. Thank you. 
    </p>
    
    <?php Pjax::begin(['enablePushState' => false /* maintain same url */, 'timeout' => 5000]); ?>
    
    <?php $form = ActiveForm::begin([
        'id'      => 'order-prewirekit-form', 
        'method'  => 'post', 
        'action'  => Url::to(['professional/order-prewirekit']), //, 'category' => 'module', 'addRow' => -1, 'delRow' => -1]),
        //'options' => ['data' => ['pjax' => true, 'method' => 'post', 'params' => ['category' => 'thankyou']]]
        'options' => ['data' => ['pjax' => false]]
    ]); ?>
    <div class="row">
        <div class="col-lg-4">
            <?php $model->accountContact = (!empty($model->accountContact) ? $model->accountContact : (isset(Yii::$app->user->identity) ? Yii::$app->user->identity->full_name: '') ); ?>
            <?= $form->field($model, 'accountContact')->textInput(['maxlength' => 255, 'options' => ['data' => ['pjax' => true]]]); ?>
            
            <?php $model->accountNumber = (!empty($model->accountNumber) ? $model->accountNumber : (isset(Yii::$app->user->identity) ? Yii::$app->user->identity->account_number: '') ); ?>
            <?= $form->field($model, 'accountNumber')->textInput(['maxlength' => 255, 'options' => ['data' => ['pjax' => true]]]); ?>
        </div>
        <div class="col-lg-4">
            <?php $model->email = (!empty($model->email) ? $model->email : (isset(Yii::$app->user->identity) ? Yii::$app->user->identity->email: '') ); ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => 255, 'options' => ['data' => ['pjax' => true]]]); ?>
            
            <?php $model->telephone = (!empty($model->telephone) ? $model->telephone : (isset(Yii::$app->user->identity) ? Yii::$app->user->identity->phone: '') ); ?>
            <?= $form->field($model, 'telephone')->textInput(['maxlength' => 255, 'options' => ['data' => ['pjax' => true]]]); ?>
        </div>
        <div class="col-lg-4">
            <?php $model->shipDate = date('Y-m-d', strtotime(date('Y-m-d')." +3 Days")); ?>
            
            <?= $form->field($model, 'shipDate', [
                'template' => '{label}<div class="input-group">
                    <span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true" 
                       onclick="document.getElementById(\'orderprewirekitform-shipdate\').select();">
                    </span>{input}</div><div>{error}</div>'
                ])->widget(\yii\jui\DatePicker::className(), [
                    'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
                    //'value' => date("Y-m-d"),
                    //'value' => date('Y-m-d', strtotime(date('Y-m-d')." +3 Days")),
                    'clientOptions' => [  // Options for JQuery UI widget (http://api.jqueryui.com/datepicker/)
                        'defaultDate'     => '+3', //'2010-01-01',
                        'currentText'     => 'Today',
                        'language'        => 'US',
                        'country'         => 'US',
                        'showAnim'        => 'fold',
                        'yearRange'       => 'c-20:c+0',
                        'changeMonth'     => true,
                        'changeYear'      => true,
                        'autoSize'        => true,
                        'showButtonPanel' => true,
                        //'showOn'        => "both",
                        //'buttonText '   => "Choose",
                        //'buttonImage'   => "images/calendar.gif",
                        //'htmlOptions'   => [
                        //    'style'       => 'width:80px;',
                        //    'font-weight' => 'x-small',
                        //],
                        //'buttonImageOnly' => true,
                    ],
                    'options' => [  // Options for HTML attributes
                        'class' => 'form-control',  // Bootstrap theme
                    ],
                    'inline' => false,
                ])->textInput(['placeholder' => 'YYYY-MM-DD'])->hint('Requested Ship Date (we will confirm if ship date can be met)') ?>
                
            <?php 
                if (isset(Yii::$app->user->identity)) {
                    $fulladdress = implode(", ", [
                        Yii::$app->user->identity->company_name, 
                        Yii::$app->user->identity->address1, 
                        Yii::$app->user->identity->address2, 
                        Yii::$app->user->identity->city, 
                        Yii::$app->user->identity->state_prov, 
                        Yii::$app->user->identity->country
                    ]);
                } else {
                    $fulladdress = '';
                }
                $model->shipTo = (!empty($model->shipTo) ? $model->shipTo : $fulladdress ); 
            ?>
            <?= $form->field($model, 'shipTo')->textArea() ?>
            
            <?php $model->shipMethod = (!empty($model->shipMethod) ? $model->shipMethod : 'FedEx (2 Day)' ); ?>
            <?= $form->field($model,"shipMethod")->label('Ship Method')->dropDownList(
                ['FedEx (2 Day)'=>'FedEx (2 Day)', 'FedEx Express (1 Day)'=>'FedEx Express (1 Day) - Additional Charges', 'Air Mail'=>'Air Mail']
                //['prompt'=>'--Select One--']    // options
            ) ?></td>
        </div>
        
        <div class="col-lg-12">
            <?php //echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                  //   'template' => '<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-4">{image}</div></div>',
                  //]) 
            ?>
        </div>
        
    </div>
    
    <!-- Modules -->
    <?= $this->render('_order-item-module-product', [
            'model'            => $model,
            'orderItemsModule' => $orderItemsModule,
            'form'             => $form,
    ]) ?>
    
    <!-- BTE / Stock Products -->
    <?= $this->render('_order-item-stock-product', [
            'model'            => $model,
            'orderItemsStock'  => $orderItemsStock,
            'form'             => $form,
    ]) ?>
    
    <!-- Spare Parts -->
    <?= $this->render('_order-item-product-part', [
            'model'            => $model,
            'orderItemsParts'  => $orderItemsParts,
            'form'             => $form,
    ]) ?>
    
    <p class="empty"></p>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Submit', ['name' => 'order-button', 'class' => 'btn btn-primary']) ?>
                <?= Html::a('Cancel', ['professional/order-prewirekit'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?php Pjax::end(); ?>

</div>
