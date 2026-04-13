<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = 'Product Overview';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    <img src="https://cdn.auditiva.us/professionals/product-overview-chart-lg.jpg" class="img-responsive" align="center" width="1140">
    
    <h3>Product Features</h3>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // record number column
            ['class' => 'yii\grid\SerialColumn'],    
            'Name',
            'Channels:text:Compression Ch',
            'GainBands:text:Bands',
            'ManualPrograms:text:Prog',
            'NoiseReduction:boolean:NR',
            'AdaptiveDirectionalChannels:boolean:Adapt Dir',
            //'AutoEnvironmentSwitching:boolean:Auto Env',
            'AdaptiveFeedbackCanceller:boolean:FBC',
            'NumberOfMicrophones:text:Mics',
            'Telecoil',
            'AutoTelecoil',
            'BatterySize',
            //'cable',
            //[
            //  'attribute' => 'cable',
            //  'format'    => 'raw',
            //  'value'     => function($data) {
            //      $label = getCableLabel($data['cable']);
            //      return ($label); 
            //  },
            //  'contentOptions' => ['style'=>'width: 130px;']
            //],
            //'connector',
            //[
            //  'attribute'      => 'connector',
            //  'value'          => 'connector',
            //  'format'         => 'raw',
            //  'contentOptions' => ['style'=>'width: 220px;']
            //],
            //'programmer',
            //[
            //  'attribute'      => 'programmer',
            //  'value'          => 'programmer',
            //  'contentOptions' => ['style'=>'width: 170px;']
            //],
            //'notes',
            //[
            //  'attribute'      => 'notes',
            //  'value'          => 'notes',
            //  'format'         => 'html',
            //],
            //['class' => 'yii\grid\ActionColumn'],  // default actions
        ],
        'summary' => '',
        //'showFooter' => true,
        //'footerRowOptions'=>['style'=>'font-weight:bold'],
    ]); ?>
    
    <?php
        //// Header
        //echo "<table class='table table-bordered table-striped table-hover'>";
        //echo "<tr>";
        //echo "  <th>Product</th>";
        //echo "  <th>Channels</th>";
        //echo "  <th>Telecoil</th>";
        //echo "  <th>Auto-Telecoil</th>";
        //echo "  <th>Battery</th>";
        //echo "</tr>";
        //
        //// Data
        //foreach($features as $key => $product) {
        //    echo "<tr>";
        //    echo "  <td>{$product['Name']}</td>";
        //    echo "  <td>{$product['Channels']}</td>";
        //    echo "  <td>{$product['Telecoil']}</td>";
        //    echo "  <td>{$product['AutoTelecoil']}</td>";
        //    echo "  <td>{$product['BatterySize']}</td>";
        //    echo "</tr>";
        //}
        //echo "</table>";
    ?>
    
    <?php
        //echo '<h3>Telecoil</h3>';
        //echo "<table class='table table-bordered table-striped table-hover'>";
        //echo "<tr><th>Product</th><th>Telecoil</th></tr>";
        //foreach($telecoil as $key => $val) {
        //    echo "<tr><td>{$key}</td><td>{$val}</td></tr>";
        //}
        //echo "</table>";
    ?>
    
    <?php
        //echo '<h3>Auto-Telecoil</h3>';
        //echo "<table class='table table-bordered table-striped table-hover'>";
        //echo "<tr><th>Product</th><th>Auto-Telecoil</th></tr>";
        //foreach($autotelecoil as $key => $val) {
        //    echo "<tr><td>{$key}</td><td>{$val}</td></tr>";
        //}
        //echo "</table>";
    ?>
</div>
