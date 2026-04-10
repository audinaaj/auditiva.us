<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\jui\DatePicker;
use skylineos\yii\s3manager\widgets\{FileInput, MediaManagerModal};

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">
 
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]); ?>

<?php
    //--------------------
    // TAB: images
    //--------------------
    $tabImages = '';

    //--------------------------------------
    // Intro image (single file)
    //--------------------------------------
    $tabImages .= '<div class="col-md-6">';
    $tabImages .= '<div class="panel panel-default">';
    $tabImages .= '  <div class="panel-heading">Image</div>';
    $tabImages .= '  <div class="panel-body">';

    $tabImages .= $form->field($model, 'full_text')->label('Link Target')->textInput(['maxlength' => 255]);

    // File input using S3 Manager
    $tabImages .= '<label>Image</label>';
    ob_start();
    echo FileInput::widget(['model' => $model, 'attribute' => 'intro_image']);
    $tabImages .= ob_get_clean();

    // Image Preview
    if (!empty($model['intro_image'])) {
        $tabImages .= '<div id="cont-img" style="margin-top:10px;"><img id="preview-content-intro_image" src="' . Yii::$app->formatter->asS3Url($model['intro_image']) . '" width="300" /></div>';
    } else {
        $tabImages .= '<div id="cont-img" style="margin-top:10px;"><img id="preview-content-intro_image" src="#" style="display:none;" width="300" /></div>';
    }
    $tabImages .= '  </div>';
    $tabImages .= '</div>'; // end panel 
    $tabImages .= '</div>'; // end col

    $tabImages .= '<div class="col-md-4">';
    $tabImages .= '<div class="panel panel-default">';
    $tabImages .= '  <div class="panel-heading">Publishing</div>';
    $tabImages .= '  <div class="panel-body">';
    
    $tabImages .= $form->field($model, 'status')->dropDownList(
        ['1'=>'Published', '0'=>'Unpublished']
        //['prompt'=>'--Select One--']    // options
    );

    $tabImages .= $form->field($model,'publish_up', [
            'template' => '{label}<div class="input-group"><span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true" onclick="document.getElementById(\'content-publish_up\').select();"></span>{input}</div>'
        ])->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
        'value' => ($model->isNewRecord ? date("Y-m-d") : $model->publish_up),
        'clientOptions' => [  // Options for JQuery UI widget
            'defaultDate' => '+7', //'2010-01-01',
            'currentText' => 'Today',
            //'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
            'language'   => 'US',
            'country'    => 'US',
            'showAnim'   => 'fold',
            'yearRange'  => 'c-20:c+0',
            'changeMonth'=> true,
            'changeYear' => true,
            'autoSize'   => true,
            'showButtonPanel' => true,
            //'showOn'     => "button",
            //'buttonImage'=> "images/calendar.gif",
            //'htmlOptions'=>[
            //    'style'=>'width:80px;',
            //    'font-weight'=>'x-small',
        ],
        'options' => [  // Options for HTML attributes
            'class' => 'form-control',  // Bootstrap theme
        ],
    ])->hint('Publishing Start Date: When to start publishing this content');
    
    $tabImages .= $form->field($model,'publish_down', [
            'template' => '{label}<div class="input-group"><span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true" onclick="document.getElementById(\'content-publish_down\').select();"></span>{input}</div>'
        ])->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
        'value' => ($model->isNewRecord ? date("Y-m-d") : $model->publish_down),
        'clientOptions' => [  // Options for JQuery UI widget
            'defaultDate' => '+7', //'2010-01-01',
            'currentText' => 'Today',
            //'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
            'language'   => 'US',
            'country'    => 'US',
            'showAnim'   => 'fold',
            'yearRange'  => 'c-20:c+0',
            'changeMonth'=> true,
            'changeYear' => true,
            'autoSize'   => true,
            'showButtonPanel' => true,
            //'showOn'     => "button",
            //'buttonImage'=> "images/calendar.gif",
            //'htmlOptions'=>[
            //    'style'=>'width:80px;',
            //    'font-weight'=>'x-small',
        ],
        'options' => [  // Options for HTML attributes
            'class' => 'form-control',  // Bootstrap theme
        ],
    ])->hint('Publishing End Date: When to stop publishing this content'); 
    $tabImages .= '</div>'; // panel-body
    $tabImages .= '</div>'; // panel
    $tabImages .= '</div>'; // column (2)

    //--------------------
    // Options
    //--------------------
    $tabImages .= '<div class="col-md-2">';
    
    // $tabOptions .= $form->field($model, 'show_title')->dropDownList(
    //         ['1'=>'Yes', '0'=>'No']
    //         //['prompt'=>'--Select One--']    // options
    //     );

    // $tabOptions .= $form->field($model, 'show_intro')->dropDownList(
    //         ['1'=>'Yes', '0'=>'No']
    //         //['prompt'=>'--Select One--']    // options
    //     );

    //$tabOptions .= $form->field($model, 'show_image')->dropDownList(
    //        ['1'=>'Yes', '0'=>'No']
    //        //['prompt'=>'--Select One--']    // options
    //    );
    $tabImages .= Html::activeHiddenInput($model, 'show_image', ['value' => true]);

    $tabImages .= Html::activeHiddenInput($model, 'content_type_id', ['value' => 7]);  // 7 = carousel

    $tabImages .= Html::activeHiddenInput($model, 'category_id', ['value' => 1]);  // 1 = uncategorized
   
    //--------------------
    // Side column
    //--------------------
    // $tabOptions .= $form->field($model, 'category_id')->label('Category')->dropDownList(ArrayHelper::map($model->categories, 'id', 'title'));
    $tabImages .= $form->field($model, 'ordering')->dropDownList(range(0, 100));
    $tabImages .= $form->field($model, 'tags')->textInput(['maxlength' => 255]);
    $tabImages .= '</div>';

    //$tabImages .= '</div>'; // end tab
?>    
    
    <?php
        echo $tabImages;
        // echo Tabs::widget([
        //     'items' => [
        //         // [
        //         //     'label' => 'Content',
        //         //     'content' => $tabContent,
        //         //     'active' => true
        //         // ],
        //         [
        //             'label' => 'Images',
        //             'content' => $tabImages,
        //             'active' => true
        //         ],
        //     ],
        // ]);
    ?>

    <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
    
    <div class="form-group col-md-12">
        <hr>
        <?= Html::submitButton($model->isNewRecord ? 
            Yii::t('app', 'Create') : 
            Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= MediaManagerModal::widget() ?>
</div>