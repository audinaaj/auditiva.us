<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Testimonials';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-testimonials">

    <h1><?= $this->title; ?></h1>
    <img src="https://cdn.auditiva.us/professionals/about-people-bw.png" class="img-responsive" align="center" width="1140">

    <p>&nbsp;</p>
    <p>&nbsp;</p>

    <blockquote>
      <p>From our recent experience working with <?= Yii::$app->params['companyNameShort'] ?>, please be sure that we have been excited to work with the <?= Yii::$app->params['companyNameShort'] ?> team. <?= Yii::$app->params['companyNameShort'] ?>'s personnel are high standard professionals, making the hearing aids business a pleasure.</p>
      <p><em>–Yannis Kontos, General Manager, Medicare I Kontos Ltd., Greece</em></p>
    </blockquote>
    
    <p>&nbsp;</p>
    <blockquote>
      <p>Working as an Authorized Distributor of <?= Yii::$app->params['companyNameShort'] ?> for the last five years, I have been supported a lot from <?= Yii::$app->params['companyNameShort'] ?>'s staff. They are not only professional individuals but also enthusiastic persons. You can ask their help whenever and whatever your need. Our company is bigger and bigger with them. Now I understand <?= Yii::$app->params['companyNameShort'] ?>'s philosophy. Exceptional Quality and Customer Service is not just a way of doing business; it is really a way of their life, and it is the key to their success.</p>
      <p><em>–Long Thanh To MD,  Audivina Advanced ENT and Hearing Center, Vietnam</em></p>
    </blockquote>
</div>
