<?php
use yii\helpers\Html;
use yii\helpers\Url;

//-------------------------------------------------------------------------------------------------
// Constants
//-------------------------------------------------------------------------------------------------
define("ENGLISH", "English");
define("GERMAN",  "German");
define("SPANISH", "Spanish");

/* @var $this yii\web\View */
$this->title = 'Product Brochures and Manuals';
$this->params['breadcrumbs'][] = ['label'=> 'Consumers', 'url' => Url::toRoute(['consumer/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="consumer-prod-brochures">
       
    <h1>Product Brochures</h1>
    
    <p>Select the appropriate button below to download a PDF of our latest product brochure:</p>
    <table class="table table-striped">
    <tbody>
        <tr><th>Product</th><th colspan="3">Document</th></tr>
        <tr bgcolor="#dedede"><td>Arco OTE Brochure</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Arco OTE Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Arco RIC Brochure</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Arco RIC Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#dedede"><td>Boost Brochure</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Boost Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Fino RIC Brochure</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Fino RIC Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#dedede"><td>Intuir Brochure</td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Intuir Brochure-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Intuir Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Ligero Brochure</td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Ligero Brochure-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Ligero Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#dedede"><td>Veloz Brochure</td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Veloz Brochure-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/marketing/product-brochures/Veloz Brochure-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
    </tbody>
    </table>
    
    <h1>User Manuals</h1>
    
    <p>Select the appropriate button below to download a PDF of our latest product user manual:</p>
    <table class="table table-striped">
    <tbody>
        <tr><th>Product</th><th colspan="3">Document</th></tr>
        <tr bgcolor="#dedede"><td>Arco User Manual</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/usermanual/Arco User Manual-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Boost User Manual</td><td><a href="https://cdn.auditiva.us/usermanual/Boost Instructions-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/usermanual/Boost Instructions-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#dedede"><td>BTE User Manual</td><td><a href="#" class="btn btn-default disabled">English </a></td><td><a href="https://cdn.auditiva.us/usermanual/BTE User Manual-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Fino User Manual</td><td><a href="https://cdn.auditiva.us/usermanual/Fino User Manual-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/usermanual/Fino User Manual-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#dedede"><td>ITE User Manual</td><td><a href="https://cdn.auditiva.us/usermanual/ITE User Manual-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="https://cdn.auditiva.us/usermanual/ITE User Manual-es.pdf" class="btn btn-primary" target="_blank">Español</a></td></tr>
        <tr bgcolor="#f5f5f5"><td>Wax Filter (HF4) Installation</td><td><a href="https://cdn.auditiva.us/usermanual/Wax Filter (HF4) Installation-en.pdf" class="btn btn-primary" target="_blank">English</a></td><td><a href="#" class="btn btn-default disabled">Español </a></td></tr>
    </tbody>
    </table>

</div>
