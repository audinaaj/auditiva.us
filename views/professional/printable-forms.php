<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Printable Forms';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

$docRootURL = 'https://cdn.auditiva.us';
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    <img src="https://cdn.auditiva.us/professionals/banner-printable-forms.jpg" class="img-responsive" align="center" width="1140">
    
    <p>&nbsp;</p>
    <p>Download the required form by right-click, "Save As":</p>
    
    <h3>Orders</h3>
    <ul>
        <li><a href="<?= $docRootURL ?>/forms/policies-and-procedures.pdf" target="_blank">Policies / Procedures</a></li>
        <li><a href="<?= $docRootURL ?>/forms/credit-application.pdf" target="_blank">Credit Application</a></li>
        <li><a href="<?= $docRootURL ?>/forms/repair-form.pdf" target="_blank">Repair/Remake/Recase Form</a></li>
    </ul>
</div>
