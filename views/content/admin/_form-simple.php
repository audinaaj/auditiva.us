<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-10">
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'category_id')->label('Category')->dropDownList(ArrayHelper::map($model->categories, 'id', 'title')) ?>
    
    <?= $form->field($model, 'tags')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'intro_text')->widget(letyii\tinymce\Tinymce::className(), [
        'options' => [
            'id' => 'testid',
        ],
        'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration
            //'plugins' => 'advlist anchor autolink autoresize autosave bbcode charmap code 
            //             colorpicker compat3x contextmenu directionality emoticons example 
            //             example_dependency fullpage fullscreen hr image insertdatetime layer 
            //             legacyoutput link lists importcss media nonbreaking noneditable 
            //             pagebreak paste preview print save searchreplace spellchecker 
            //             tabfocus table template textcolor textpattern visualblocks visualchars wordcount',
            'plugins' => 'code image link media table template hr spellchecker', // full list: http://www.tinymce.com/wiki.php/Plugins
            'templates' => [ 
                ['title' => 'Template 1', 'description' => 'Basic Template', 'content' => '<b>Basic Template</b>'], 
                ['title' => 'Template 2', 'description' => 'Dev Template', 'url' => 'development.html']
            ],
            'link_list' => [
                [
                    'title' => 'My page 1',
                    'value' => 'http://www.tinymce.com',
                ],
                [
                    'title' => 'My page 2',
                    'value' => 'http://www.tinymce.com',
                ],
            ],
            'browser_spellcheck' => true,
            'toolbar'=> 'undo redo | styleselect | removeformat bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
            //'menubar'=> 'tools table view insert edit format',
            'menu' => [ // this is the complete default configuration
                'file'   => ['title' => 'File',   'items' => 'newdocument'],
                'edit'   => ['title' => 'Edit'  , 'items' => 'undo redo | cut copy paste pastetext | selectall'],
                'insert' => ['title' => 'Insert', 'items' => 'link media | template hr'],
                'view'   => ['title' => 'View'  , 'items' => 'visualaid'],
                'format' => ['title' => 'Format', 'items' => 'bold italic underline strikethrough superscript subscript | formats | removeformat'],
                'table'  => ['title' => 'Table' , 'items' => 'inserttable tableprops deletetable | cell row column'],
                'tools'  => ['title' => 'Tools' , 'items' => 'spellchecker code'],
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'full_text')->widget(letyii\tinymce\Tinymce::className(), [
            'options' => [
                'id' => 'testid',
            ],
            'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration
                'height' => 300
                ],
        ]); ?>

    </div>
    <div class="col-md-2">
    
    
    <?= $form->field($model, 'intro_image')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'intro_image_float')->dropDownList(
                ['left'=>'Left', 'right'=>'Right', 'center'=>'Center']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'main_image')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'main_image_float')->dropDownList(
                ['left'=>'Left', 'right'=>'Right', 'center'=>'Center']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_title')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_intro')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_image')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_hits')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'show_rating')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?= $form->field($model, 'content_type_id')->label('Content Type')->dropDownList(ArrayHelper::map($model->contentTypes, 'id', 'title')) ?>

    <?= $form->field($model, 'featured')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>

    <?php for($i=0, $order=array(); $i<=100; $i++) { $order[] = $i; } ?>
    <?= $form->field($model, 'ordering')->dropDownList($order) ?>

    <?=  $form->field($model, 'publish_up')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99/99/9999',
    ]); ?>

    <?=  $form->field($model, 'publish_down')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '99/99/9999',
    ]); ?>

    <?= $form->field($model, 'status')->dropDownList(
                ['1'=>'Yes', '0'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 
            Yii::t('app', 'Create') : 
            Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
