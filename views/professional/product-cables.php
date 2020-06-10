<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
//use yii\widgets\ListView;

//-------------------------------------------------------------------------------------------------
// Constants
//-------------------------------------------------------------------------------------------------
define("ENGLISH", "English");
define("SPANISH", "Spanish");

/* @var $this yii\web\View */
$this->title = 'Product Cable Reference';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="professional-prod-specs">
       
    <h1><?= $this->title; ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'template' => '<tr><th width="100">{label}</th><td width="100">{value}</td></tr>',  // row template
        'columns' => [
            // record number column
            ['class' => 'yii\grid\SerialColumn'],    
            'name',
            'style',
            //'cable',
            [
              'attribute' => 'cable',
              'format'    => 'raw',
              'value'     => function($data) {
                  switch($data['cable']) {
                    case 'Black-5x':
                        $label = '<span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x</span>';
                        break;
                        
                        
                    case 'Black-5x with Pill':
                        $label = '<span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x with Pill</span>';
                        break;
                        
                    case 'Gray-4x':
                        $label = '<span class="label label-color" style="background-color: #adadad; color: #fff;">Gray-4x</span>';
                        break;
                        
                    default:
                        $label = '<span class="label label-color" style="background-color: #ff0000; color: #fff;">Unknown</span>';
                        break;
                  }
                  return ($label); 
              },
              'contentOptions' => ['style'=>'width: 130px;']
            ],
            //'connector',
            [
              'attribute'      => 'connector',
              'value'          => 'connector',
              'contentOptions' => ['style'=>'width: 220px;']
            ],
            //'programmer',
            [
              'attribute'      => 'programmer',
              'value'          => 'programmer',
              'contentOptions' => ['style'=>'width: 160px;']
            ],
            'notes',
            //['class' => 'yii\grid\ActionColumn'],  // default actions
        ],
        //'showFooter' => true,
        //'footerRowOptions'=>['style'=>'font-weight:bold'],
    ]); ?>
    
    <p>
    
    
</div>

