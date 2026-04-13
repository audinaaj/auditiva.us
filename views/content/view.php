<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->title;
if (!empty($model->category) && ($model->category->alias == 'home')) {
    // no extra breadcrumbs for Home article
} else if (!empty($model->category)) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', $model->category->title), 
        'url'   => ['index', 'category' => $model->category->alias]
    ];
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => ['index']];
}    
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">

<?php

    // Edit button (for Admin only)
    $curAction = Yii::$app->controller->action->id;
    if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) {
        $btnEdit = Html::a('<span class="glyphicon glyphicon-edit"></span>',  
            Yii::$app->urlManager->createUrl(['content/update', 'id'=>$model['id']], ['class'=>'btn btn-default', 'target' => '_self']) 
        ) . ' ';
    } else {
        $btnEdit = '';
    }

    // Introduction Text
    if ($model['show_title']) {
        echo '<h1>' . $btnEdit . Html::encode($this->title) . '</h1>';
    } else {
        echo '<h1>' . $btnEdit . '</h1>';
    }
    
    // Intro Text
    //echo '<div class="media-body">';
    echo '<div>';
    echo '  <div style="margin: 10px;">';
    
    // Introduction Text
    if ($model['show_intro']) {
        echo '  <hr>';
        echo '    <h3 class="media-heading"><small>' . $model['intro_text'] . '</small></h3>';
        echo '  <hr>';
    }
    
    // Image (Left/Right)
    if (!empty($model['main_image']) && $model['show_image']) {
        echo Html::img(Yii::$app->formatter->asS3Url($model['main_image']), [
            'align' => $model['main_image_float'], 
            //'width' => '1100', 
            'style' => "margin: 20px; max-width: 1100px",
            'class' => "img-thumbnail"
        ]);
    }
    
    // Content Full Text
    //echo HtmlPurifier::process($model->full_text);
    echo $model['full_text'] . "\n";
?>

    <hr/>
  </div>
</div>

</div>
