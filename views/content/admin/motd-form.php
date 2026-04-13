<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">
 
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]); ?>

    <div class="col-md-8"><br />

        <?= $form->field($model, 'intro_text')->label('Text')->widget(letyii\tinymce\Tinymce::class, [
            'options' => [
                'id' => 'idIntroText',
            ],
            'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration
                //'plugins' => 'advlist anchor autolink autoresize autosave bbcode charmap code 
                //             colorpicker compat3x contextmenu directionality emoticons example 
                //             example_dependency fullpage fullscreen hr image insertdatetime layer 
                //             legacyoutput link lists importcss media nonbreaking noneditable 
                //             pagebreak paste preview print save searchreplace spellchecker 
                //             tabfocus table template textcolor textpattern visualblocks visualchars wordcount',
                'plugins' => 'code image link media table hr spellchecker', // full list: http://www.tinymce.com/wiki.php/Plugins
                'templates' => [ 
                    ['title' => 'Template 1', 'description' => 'Basic Template', 'content' => '<b>Basic Template</b>'], 
                    ['title' => 'Template 2', 'description' => 'Dev Template', 'url' => 'development.html']
                ],
                'browser_spellcheck' => true,
                'toolbar'=> 'undo redo | styleselect | removeformat bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
                //'menubar'=> 'tools table view insert edit format',
                'menu' => [ // this is the complete default configuration
                    'file'   => ['title' => 'File',   'items' => 'newdocument'],
                    'edit'   => ['title' => 'Edit'  , 'items' => 'undo redo | cut copy paste pastetext | selectall'],
                    'insert' => ['title' => 'Insert', 'items' => 'link media image | template hr'],
                    'view'   => ['title' => 'View'  , 'items' => 'visualaid'],
                    'format' => ['title' => 'Format', 'items' => 'bold italic underline strikethrough superscript subscript | formats | removeformat'],
                    'table'  => ['title' => 'Table' , 'items' => 'inserttable tableprops deletetable | cell row column'],
                    'tools'  => ['title' => 'Tools' , 'items' => 'spellchecker code'],
                ],
                'dialog' => ['width' => 600],
            ],
        ]) ?> 
    
    </div>

    <div class="col-md-2"><br />
    
        <?= $form->field($model, 'show_title')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        ) ?>

        <?= Html::activeHiddenInput($model, 'show_intro', ['value' => 1]) ?>
        <?= Html::activeHiddenInput($model, 'show_image', ['value' => true]) ?>
        <?= Html::activeHiddenInput($model, 'content_type_id', ['value' => 8])  // 8 = motd  ?>

        <?= $form->field($model, 'category_id')->label('Category')->dropDownList(ArrayHelper::map($model->categories, 'id', 'title')) ?>
        <?= $form->field($model, 'tags')->textInput(['maxlength' => 255]) ?>
        
    </div>
    
    <div class="col-md-2"><br />
    <?= $form->field($model, 'status')->dropDownList(
        ['1'=>'Published', '0'=>'Unpublished']
        //['prompt'=>'--Select One--']    // options
    ) ?>
    
    <?= $form->field($model,'publish_up', [
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
    ])->hint('Publishing Start Date: When to start publishing this content') ?>
    
    <?= $form->field($model,'publish_down', [
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
    ])->hint('Publishing End Date: When to stop publishing this content') ?>
    
    <?= Html::activeHiddenInput($model, 'featured', ['value' => 0]) ?>
    
    </div>

    <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
    
    <div class="form-group col-md-10">
        <?= Html::submitButton($model->isNewRecord ? 
            Yii::t('app', 'Create') : 
            Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

?>