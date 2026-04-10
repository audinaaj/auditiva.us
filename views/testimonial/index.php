<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Testimonials');
if (!empty($parent_breadcrumb_label) && !empty($parent_breadcrumb_route)) {
    $this->params['breadcrumbs'][] = ['label'=> $parent_breadcrumb_label, 'url' => Url::toRoute([$parent_breadcrumb_route])];
} 
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-testimonials">
    <h1><?= $this->title; ?></h1>
    <img src="<?= Yii::$app->homeUrl; ?>img/aboutus/about-people-bw.png" class="img-responsive" align="center" width="1140">

    <p>&nbsp;</p>
    <p>&nbsp;</p>

    <?php if(count($models) > 0): ?>
    <?php foreach($models as $row): ?>
        <blockquote>
          <p><?= $row->comment ?></p>
          <p><em>–<?= $row->author ?>, <?= $row->location ?></em></p>
        </blockquote>
        <p>&nbsp;</p>
    <?php endforeach; ?>
    <?php else: ?>
        <blockquote>
          <p>No testimonials available.</p>
        </blockquote>
        <p>&nbsp;</p>
    <?php endif; ?>
    
</div>
