<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form ActiveForm */

$this->title = 'Content';
if (count($models) > 0) {
    $this->title = $models[0]['category']['title'];  //'Content';
    $content = '';
} else {
    $content = '<H3>No articles available</H3>';   
}
//if (!empty($section)) {
//    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => [$section]];
//}    
$this->params['breadcrumbs'][] = Html::encode($this->title);

//echo '<pre>'.print_r($models[0]['category']['title'], true).'</pre>';
?>
<div class="content-index">

<?= $content ?>

<?php
//--------------------------------
// Admin 
//--------------------------------
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
    echo $btnViewAdminIndex = Html::a('<span class="glyphicon glyphicon-edit"></span> ' . Yii::t('app', 'Manage Content'),  
        [   'content/admin-index',
            'category' => $category,
             'tags'    => $tags,
             'ord'     => $ord,
             'by'      => $by,
        ], 
        ['class'=>'btn btn-default', 'target' => '_self'] 
    );
} 
    
foreach ($models as $model) {
    echo '<div class="media">';
   
    // Image Data
    $hasImage = (!empty($model['intro_image']));
    $imgData = '';
    if (!empty($model['intro_image'])) {
        $imgData = '<div class="media-' . $model['main_image_float'] . ' col-lg-4 col-xs-12">';

        // Link intro image to article (if available)
        $imgThumb = Html::img(Yii::$app->formatter->asS3Url($model['intro_image']), [
            'align' => $model['intro_image_float'], 
            'style' => "margin: 10px; width: 100%",
            'class' => "img-responsive img-thumbnail" // "img-rounded", "img-circle"
        ]);
        if (!empty($model['full_text'])) {
            $imgData .= Html::a($imgThumb, ['content/view', 'id'=>$model['id']]);  // thumbnail with hyperlink
        } else {
            $imgData .= $imgThumb;  // thumbnail with no hyperlink
        }
        $imgData .= '</div>';
    }
    
    // Edit button (for Admin only)
    $curAction = Yii::$app->controller->action->id;
    if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) {
        $btnEdit = Html::a('<span class="glyphicon glyphicon-edit"></span>',  
            Yii::$app->urlManager->createUrl(['content/update', 'id'=>$model['id']], ['class'=>'btn btn-default', 'target' => '_self']) 
        ) . ' ';
    } else {
        $btnEdit = '';
    }

    echo '<div class="row">';
    // Image (Left)
    if ($model['intro_image_float'] === 'left') {
        echo $imgData;
    }
    
    // Intro Text
    if ($hasImage) {
        //echo '<div class="media-body col-lg-8 col-xs-12">';
        echo '<div class="col-lg-8 col-xs-12">';
    } else {
        //echo '<div class="media-body col-lg-12 col-xs-12">';
        echo '<div class="col-lg-12 col-xs-12">';
    }
    echo '<div style="margin: 10px;">';
    echo '<h3 class="media-heading">' . $btnEdit . $model['title'] . '</h3>';
    echo "<p>" . $model['intro_text'] . "</p>";
    if (!empty($model['full_text'])) {
        echo Html::a('Read More...', 
             ['content/view', 'id'=>$model['id']], ['class'=>'btn btn-default']
         );
    }
    
    echo "</div>";
    echo "</div>";
    
    // Image (Right)
    if ($model['intro_image_float'] === 'right') {
        echo $imgData;
    }
    
    echo "</div>";  // end row
    echo "</div>";  // end class-media
}

?>

</div><!-- content-index -->
