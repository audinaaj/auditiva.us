<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
    // TAB: Content
    //--------------------
    $tabContent = '<div class="col-md-10"><br />';

    $tabContent .= $form->field($model, 'intro_text')->widget(letyii\tinymce\Tinymce::class, [
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
            'plugins' => 'code image link media table hr', // full list: http://www.tinymce.com/wiki.php/Plugins
            'templates' => [ 
                ['title' => 'Template 1', 'description' => 'Basic Template', 'content' => '<b>Basic Template</b>'], 
                ['title' => 'Template 2', 'description' => 'Dev Template', 'url' => 'development.html']
            ],
            'browser_spellcheck' => true,
            'toolbar'=> 'undo redo | styleselect | removeformat bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
            //'menubar'=> 'tools table view insert edit format',
            'menu' => [ // this is the complete default configuration
                //'file'   => ['title' => 'File',   'items' => 'newdocument'],
                'file'   => ['title' => 'File',   'items' => ''],
                'edit'   => ['title' => 'Edit'  , 'items' => 'undo redo | cut copy paste pastetext | selectall'],
                'insert' => ['title' => 'Insert', 'items' => 'link media image | template hr'],
                'view'   => ['title' => 'View'  , 'items' => 'visualaid'],
                'format' => ['title' => 'Format', 'items' => 'bold italic underline strikethrough superscript subscript | formats | removeformat'],
                'table'  => ['title' => 'Table' , 'items' => 'inserttable tableprops deletetable | cell row column'],
                'tools'  => ['title' => 'Tools' , 'items' => 'spellchecker code'],
            ],
            'dialog' => ['width' => 600],
        ],
    ]); 

    $tabContent .= $form->field($model, 'full_text')->widget(letyii\tinymce\Tinymce::class, [
        'options' => [
            'id' => 'idFullText',
        ],
        'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration
            //'plugins' => 'advlist anchor autolink autoresize autosave bbcode charmap code 
            //             colorpicker compat3x contextmenu directionality emoticons example 
            //             example_dependency fullpage fullscreen hr image imagetools insertdatetime layer 
            //             legacyoutput link lists importcss media nonbreaking noneditable 
            //             pagebreak paste preview print save searchreplace spellchecker 
            //             tabfocus table template textcolor textpattern visualblocks visualchars wordcount',
            //'plugins' => 'code image link media table hr spellchecker imagetools responsivefilemanager', // full list: http://www.tinymce.com/wiki.php/Plugins
            'plugins' => 'code image link media table hr imagetools lists', // full list: http://www.tinymce.com/wiki.php/Plugins
            'templates' => [ 
                ['title' => 'Template 1', 'description' => 'Basic Template', 'content' => '<b>Basic Template</b>'], 
                ['title' => 'Template 2', 'description' => 'Dev Template', 'url' => 'development.html']
            ],
            // Image plugin settings:
            //'image_list' => [
            //    ['title' => 'Dog', 'value' => 'mydog.jpg'],
            //    ['title' => 'Cat', 'value' => 'mycat.gif']
            //],
            'image_advtab' => true,
            //'style_formats' => [   // NOTE: defining this redefines default style_formats
            //    ['title' => 'Image Left', 'selector' => 'img', 'styles' => [
            //        'float' => 'left', 
            //        'margin' => '0 10px 0 10px'
            //    ]],
            //    ['title' => 'Image Right', 'selector' => 'img', 'styles' => [
            //        'float' => 'right', 
            //        'margin' => '0 10px 0 10px'
            //    ]]
            //],
            // ResponsiveFileManager plugin settings:
            //'filemanager_title'         => 'Media File Manager',
            //'filemanager_access_key'    => 'myPrivateKey',
            //'external_filemanager_path' => '/acme/site/backend/web/filemanager/',
            //'external_filemanager_path' =>  Yii::$app->urlManager->createUrl('') . 'filemanager/',
            //'external_filemanager_path' =>  Yii::$app->urlManager->createUrl('') . 'filemanager/',
            'external_plugins'          => [
                //'filemanager'           => '/acme/site/backend/web/filemanager/plugin.min.js',
                //'filemanager'           => Yii::$app->urlManager->createUrl('') . 'filemanager/plugin.min.js',
                //'filemanager'           => Yii::$app->urlManager->createUrl('') . 'filemanager/plugin.min.js',
                //'responsivefilemanager' => '/acme/site/vendor/letyii/yii2-tinymce/tinymce/plugins/responsivefilemanager/plugin.min.js',
                //'responsivefilemanager' => str_replace('/frontend/web/', '', str_replace('/backend/web/', '', Yii::$app->homeUrl)) . '/vendor/letyii/yii2-tinymce/tinymce/plugins/responsivefilemanager/plugin.min.js',
                //'responsivefilemanager' => Yii::$app->urlManager->createUrl('') . '../../vendor/letyii/yii2-tinymce/tinymce/plugins/responsivefilemanager/plugin.min.js',
                //'responsivefilemanager' => Yii::$app->urlManager->createUrl('') . 'filemanager/plugin.min.js',
            ],
            //'external_plugins'          => ['responsivefilemanager' => '/acme/site/vendor/letyii/yii2-tinymce/tinymce/plugins/responsivefilemanager/plugin.min.js'],
            //'external_plugins'          => ['filemanager' => '/acme/site/backend/web/filemanager/plugin.min.js'],
            // Other:
            'browser_spellcheck' => true,
            //'toolbar' => 'responsivefilemanager undo redo | styleselect | removeformat bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media code',
            'toolbar' => 'filemanager undo redo | styleselect | removeformat bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code',
            //'menubar'=> 'tools table view insert edit format',
            'menu' => [ // this is the complete default configuration
                'file'   => ['title' => 'File',   'items' => 'newdocument'],
                'edit'   => ['title' => 'Edit'  , 'items' => 'undo redo | cut copy paste pastetext | selectall'],
                'insert' => ['title' => 'Insert', 'items' => 'link media image | template hr'],
                'view'   => ['title' => 'View'  , 'items' => 'visualaid visualblocks visualchars'],
                'format' => ['title' => 'Format', 'items' => 'bold italic underline strikethrough superscript subscript | formats | removeformat'],
                'table'  => ['title' => 'Table' , 'items' => 'inserttable tableprops deletetable | cell row column'],
                'tools'  => ['title' => 'Tools' , 'items' => 'spellchecker code'],
            ],
            'dialog' => ['width' => 600],
            'height' => 600,
            // allow icons
            'extended_valid_elements' => 'span[class|style],i[class|style]',
        ],
    ]); 
    $tabContent .= '</div>';

    // Side column
    $tabContent .= '<div class="col-md-2"><br />';
    $tabContent .= $form->field($model, 'category_id')->label('Category')->dropDownList(ArrayHelper::map($model->categories, 'id', 'title'));
    $tabContent .= $form->field($model, 'tags')->textInput(['maxlength' => 255]);
    $tabContent .= $form->field($model, 'status')->dropDownList(
        ['1'=>'Published', '0'=>'Unpublished']
        //['prompt'=>'--Select One--']    // options
    );
    $tabContent .= $form->field($model, 'featured')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );
    $tabContent .= '</div>';
    
    //--------------------
    // TAB: images
    //--------------------
    $tabImages = '<div class="col-md-12"><br />';

    //--------------------------------------
    // Intro image (single file)
    //--------------------------------------
    $tabImages .= '<div class="col-md-6">';
    $tabImages .= '<div class="panel panel-default">';
    $tabImages .= '  <div class="panel-heading">Intro Image</div>';
    $tabImages .= '  <div class="panel-body">';
    // Select Image (using Bootstrap Modal window)
    $tabImages .= '<label>URL</label>';
    $tabImages .= '<div class="input-group col-md-10">';
    
    $tabImages .= '  <span class="input-group-btn">';
    //$tabImages .= $form->field($model, 'intro_image', ['options'=>['tag'=>'div', 'class'=>'help-block']])->textInput(['maxlength' => 255])->Label(false);
    // File input using S3 Manager
    $tabImages .= '<label>Image</label>';
    ob_start();
    echo FileInput::widget(['model' => $model, 'attribute' => 'intro_image']);
    $tabImages .= ob_get_clean();

    //$tabImages .= '<button id="btnIntroImg" type="button" class="btn btn-primary" data-toggle="modal" data-target="#winModalMediaGallery" data-field="content-intro_image">Select</button>';
    $tabImages .= '  </span>'; 

    $tabImages .= '</div>'; // end inputgroup
    $tabImages .= $form->field($model, 'intro_image_float')->Label('Position')->dropDownList(
            ['left'=>'Left', 'right'=>'Right', 'none'=>'None']
            //['prompt'=>'--Select One--']    // options
        );
        
    // Image Preview
    if (!empty($model['intro_image'])) {
        $img = Yii::$app->formatter->asS3Url($model['intro_image']);
        $tabImages .= '<div id="cont-img" style="margin-top:10px;"><img id="preview-content-intro_image" src="' . $img . '" width="300" /></div>';
    } else {
        $tabImages .= '<div id="cont-img" style="margin-top:10px;"><img id="preview-content-intro_image" src="#" style="display:none;" width="300" /></div>';
    }
    $tabImages .= '  </div>';
    $tabImages .= '</div>'; // end panel 
    $tabImages .= '</div>'; // end col
        
    //--------------------------------------
    // Main image (single file)
    //--------------------------------------
    $tabImages .= '<div class="col-md-6">';
    $tabImages .= '<div class="panel panel-default">';
    $tabImages .= '  <div class="panel-heading">Main Image</div>';
    $tabImages .= '  <div class="panel-body">';
    // Select Image (using Bootstrap Modal window)
    $tabImages .= '<label>URL</label>';
    $tabImages .= '<div class="input-group col-md-10">';
    $tabImages .= '  <span class="input-group-btn">';
    // $tabImages .= $form->field($model, 'main_image', ['options'=>['tag'=>'div', 'class'=>'help-block']])->textInput(['maxlength' => 255])->Label(false);
    // $tabImages .= '<button id="btnMainImg" type="button" class="btn btn-primary" data-toggle="modal" data-target="#winModalMediaGallery" data-field="content-main_image">Select</button>';
    $tabImages .= '<label>Image</label>';
    ob_start();
    echo FileInput::widget(['model' => $model, 'attribute' => 'main_image']);
    $tabImages .= ob_get_clean();
     $tabImages .= '  </span>'; 
    $tabImages .= '</div>'; // end inputgroup
    $tabImages .= $form->field($model, 'main_image_float')->Label('Position')->dropDownList(
            ['left'=>'Left', 'right'=>'Right', 'center'=>'Center']
            //['prompt'=>'--Select One--']    // options
        );
    // Image Preview
    if (!empty($model['main_image'])) {
        $img = Yii::$app->formatter->asS3Url($model['main_image']);
        $tabImages .= '<div id="cont-img" style="margin-top: 10px;"><img id="preview-content-main_image" src="' . $img . '" width="300" /></div>';
    } else {
        $tabImages .= '<div id="cont-img" style="margin-top: 10px;"><img id="preview-content-main_image" src="#" style="display:none;" width="300" /></div>';
    }
    $tabImages .= '  </div>';
    $tabImages .= '</div>'; // end panel
    $tabImages .= '</div>'; // end col
    $tabImages .= '</div>'; // end tab
    
    //--------------------
    // TAB: Publishing
    //--------------------
    $tabPublishing = '<div class="col-md-12"><br />';
    
    $tabPublishing .= $form->field($model,'publish_up', [
            'template' => '{label}<div class="input-group"><span class="input-group-addon glyphicon glyphicon-calendar" aria-hidden="true" onclick="document.getElementById(\'content-publish_up\').select();"></span>{input}</div>'
        ])->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'php:Y-m-d',  // 'php:Y-m-d' is the only supported format
        'value' => ($model->isNewRecord ? date("Y-m-d") : $model->publish_up),
        'clientOptions' => [  // Options for JQuery UI widget (http://api.jqueryui.com/datepicker/)
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
            //'showOn'      => "button",
            //'buttonText ' => "Choose",
            //'buttonImage' => "images/calendar.gif",
            //'htmlOptions' => [
            //    'style'       => 'width:80px;',
            //    'font-weight' => 'x-small',
            //],
            //'buttonImageOnly' => true,
        ],
        'options' => [  // Options for HTML attributes
            'class' => 'form-control',  // Bootstrap theme
        ],
    ])->hint('Publishing Start Date: When to start publishing this content');
    
    $tabPublishing .= $form->field($model,'publish_down', [
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
    $tabPublishing .= '</div>';

    //--------------------
    // TAB: Options
    //--------------------
    $tabOptions = '<div class="col-md-12"><br />';
    
    $tabOptions .= $form->field($model, 'show_title')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );

    $tabOptions .= $form->field($model, 'show_intro')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );

    $tabOptions .= $form->field($model, 'show_image')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );

    $tabOptions .= $form->field($model, 'show_hits')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );

    $tabOptions .= $form->field($model, 'show_rating')->dropDownList(
            ['1'=>'Yes', '0'=>'No']
            //['prompt'=>'--Select One--']    // options
        );

    $tabOptions .= $form->field($model, 'content_type_id')->label('Content Type')->dropDownList(
        ArrayHelper::map($model->contentTypes, 'id', 'title')
    );

    for($i=0, $order=array(); $i<=100; $i++) { 
        $order[] = $i; 
    } 
    $tabOptions .= $form->field($model, 'ordering')->dropDownList($order);

    $tabOptions .= '</div>';
?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Content',
                'content' => $tabContent,
                'active' => true
            ],
            [
                'label' => 'Images',
                'content' => $tabImages,
            ],
            [
                'label' => 'Publishing',
                'content' => $tabPublishing,
            ],
            [
                'label' => 'Options',
                'content' => $tabOptions,
            ],
        ],
    ]); ?>

    <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>">
    
    <div class="form-group col-md-10">
        <?= Html::submitButton($model->isNewRecord ? 
            Yii::t('app', 'Create') : 
            Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) 
        ?>
        <?= (!$model->isNewRecord ? Html::a(Yii::t('app', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) : '') ?> 
    </div>

    <?php ActiveForm::end(); ?>

    <?= MediaManagerModal::widget() ?>
</div>