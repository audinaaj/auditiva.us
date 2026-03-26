<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Printable Forms';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

$docRootURL = Yii::$app->urlManager->createUrl('');
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    <img src="<?= Yii::$app->homeUrl; ?>img/professionals/banner-printable-forms.jpg" class="img-responsive" align="center" width="1140">
    
    <p>&nbsp;</p>
    <p>Download the required form by right-click, "Save As":</p>
    
    <h3>Orders</h3>
    <ul>
        <li><a href="<?= $docRootURL ?>media/forms/policies-and-procedures.pdf" target="_blank">Policies / Procedures</a></li>
        <li><a href="<?= $docRootURL ?>media/forms/credit-application.pdf" target="_blank">Credit Application</a></li>
        <li><a href="<?= $docRootURL ?>media/forms/order-form.pdf" target="_blank">Order Form</a></li>
        <li><a href="<?= $docRootURL ?>media/forms/repair-form.pdf" target="_blank">Repair/Remake/Recase Form</a></li>
        <!-- <li><a href="< ?= $docRootURL ? >media/forms/return-for-credit-en.pdf" target="_blank">Return for Credit Form</a></li> -->
    </ul>
    
    <h3>Documentation</h3>
    <ul>
        <!-- <li><a href="<?= $docRootURL ?>media/catalog/Guide for IRIC Propeller Placement-Misc-en.pdf" target="_blank">Guide for IRIC Proper Propeller Placement</a></li> -->
        <li><a href="<?= $docRootURL ?>media/catalog/Guide for Module Code Ordering-Misc-en.pdf" target="_blank">Guide for Module Code Ordering</a></li>
    </ul>

</div>
