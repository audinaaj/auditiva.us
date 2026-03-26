<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use app\models\UtilsFitpro;

/* @var $this yii\web\View */
$this->title = 'fitPRO Passwords';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = ['label'=> 'Software', 'url' => Url::toRoute(['professional/software'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

?>

<div class="site-ezfit-password">
       
    <h1><?= $this->title; ?></h1>
    
    
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><h3>fitPRO 5<h3></div>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php Pjax::begin(); ?>
                        <?= $this->render('ezfit-password-table', ['days' => 30, 'version' => UtilsFitpro::EZFIT_5]); ?>
                        <?php Pjax::end(); ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><h3>fitPRO 4<h3></div>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <?php Pjax::begin(); ?>
                        <?= $this->render('ezfit-password-table', ['days' => 30, 'version' => UtilsFitpro::EZFIT_4]); ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
