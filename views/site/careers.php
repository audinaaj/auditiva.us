<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Careers';
$this->params['breadcrumbs'][] = ['label'=> 'About Us', 'url' => Url::toRoute(['site/about'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-careers">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Although we do not have positions open at this time, we do keep resumes on file for future consideration.</p>

    <p>If you would like to join the <?= Yii::$app->params['companyNameShort'] ?> team, feel free to send your resume to us at:</p>

    <blockquote>
    <p>Human Resources Manager<br/>
    <?= Yii::$app->params['companyName'] ?><br/>
    <?= Yii::$app->params['companyAddress'] ?>
    </blockquote>

    <blockquote>
    <p>Fax: <?= Yii::$app->params['companyFax'] ?></p>

    <p>E-mail: <a href="#"><?= Yii::$app->params['companyEmail'] ?></a>  (plain text or PDF attachments)</p>
    </blockquote>

    <p>&nbsp;
</div>
