<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Product Specifications';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    
    <div class="contentpane">
    <iframe id="blockrandom"
        name="iframe"
        src="<?= Yii::$app->params['companyWebsite'] ?>/catalog/"
        width="100%"
        height="800"
        scrolling="auto"
        frameborder="1"
        class="wrapper">
        This option will not work correctly. Unfortunately, your browser does not support inline frames.</iframe>
    </div>

</div>
