<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
//use yii\widgets\ListView;

/* @var $this yii\web\View */
$this->title = 'Cable Reference';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

$docRootURL = Yii::$app->urlManager->createUrl('');
?>
<div class="professional-cable-reference">
    
    <a name="top"></a>
    
    <a name="CableWizard"></a>
    <h1>Cable Wizard 
        <?= Html::a('<i class="glyphicon glyphicon-print d-icon"></i>' . ' Print', 
             ['professional/cable-reference-pdf'], ['class'=>'btn btn-default pull-right']) 
        ?>
        <?= Html::a('Housings',     '#Housings',    ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Programmers',  '#Programmers', ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Connectors',   '#Connectors',  ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Cables',       '#Cables',      ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Cable Reference', '#CableReference', ['class'=>'btn btn-default pull-right']) ?>
    </h1>
    <div class="row">
        <div class="col-md-6">
            <?= Html::beginForm(['professional/cable-reference'], 'post', ['data-pjax' => '', 'class' => 'form-inline', 'id' => 'idProductListForm']); ?>
                Product to Search<br/>
                <?= Html::ListBox('product', '', getProductsForListBox($data) /* ArrayHelper::map($data, 'product', 'product') */, [
                        'id'       => 'idProductList', 
                        'class'    => 'form-control', 
                        'size'     => '25', 
                        'style'    => 'width: 100%', 
                ])?>
            <?= Html::endForm() ?>
        </div>
        <div class="col-md-6">
            <?= Html::tag('div', '...', ['id' => 'product_search_results']); ?>
        </div>
    </div>
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    <a name="CableReference"></a>
    <h1><?= $this->title; ?> 
        <?= Html::a('<i class="glyphicon glyphicon-print d-icon"></i>' . ' Print', 
             ['professional/cable-reference-pdf'], ['class'=>'btn btn-default pull-right']) 
        ?>
        <?= Html::a('Housings',     '#Housings',    ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Programmers',  '#Programmers', ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Connectors',   '#Connectors',  ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Cables',       '#Cables',      ['class'=>'btn btn-default pull-right']) ?>
        <?= Html::a('Cable Wizard', '#CableWizard', ['class'=>'btn btn-default pull-right']) ?>
    </h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // record number column
            ['class' => 'yii\grid\SerialColumn'],    
            'product',
            'housing',
            //'cable',
            [
              'attribute' => 'cable',
              'format'    => 'raw',
              'value'     => function($data) {
                  $label = getCableLabel($data['cable']);
                  return ($label); 
              },
              'contentOptions' => ['style'=>'width: 130px;']
            ],
            //'connector',
            [
              'attribute'      => 'connector',
              'value'          => 'connector',
              'format'         => 'raw',
              'contentOptions' => ['style'=>'width: 220px;']
            ],
            //'programmer',
            [
              'attribute'      => 'programmer',
              'value'          => 'programmer',
              'contentOptions' => ['style'=>'width: 170px;']
            ],
            //'notes',
            [
              'attribute'      => 'notes',
              'value'          => 'notes',
              'format'         => 'html',
            ],
            //['class' => 'yii\grid\ActionColumn'],  // default actions
        ],
        'summary' => '',
        //'showFooter' => true,
        //'footerRowOptions'=>['style'=>'font-weight:bold'],
    ]); ?>
    
    <p>
    
    <a name="Cables"></a>
    <h1>Cables <?= Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']) ?></h1>
    <p>These are all the supported Cables.  </p>
    <div class="alert alert-warning" role="alert">NOTE: Not all cables are supported by all products and programming box combinations.  
    Please refer to the <a href="#CableReference">Cable Reference</a> to verify the cable to use.</div>

    <table class="table table-striped">
    <tr><th>Name</th><th>Cable</th><th>Compatibility</th><th>Notes</th></tr>
    <?php
        foreach($dataCables as $row) {
            echo "<tr>";
            echo "<td><h3>".getCableLabel($row['name'])."</h3></td>";
            echo "<td><img src='{$docRootURL}media/reference/{$row['image']}' class='img-responsive' align='center' width='200'></td>";
            echo "<td>{$row['compatible']}</td>";
            echo "<td>{$row['notes']}</td>";
            echo "</tr>";
        }
    ?>
    </table>
    
    <a name="Connectors"></a>
    <h1>Connectors <?= Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']) ?></h1>
    <p>These are all the supported connectors.  </p>
    <div class="alert alert-warning" role="alert">NOTE: Not all connectors are supported by all products and cable combinations.  
    Please refer to the <a href="#CableReference">Cable Reference</a> to verify the connector to use.</div>

    <table class="table table-striped">
    <tr><th>Name</th><th>Connector</th><th>Notes</th></tr>
    <?php
        foreach($dataConnectors as $row) {
            echo "<tr>";
            echo "<td style='width: 250px'>{$row['name']}</td>";
            echo "<td style='width: 225px'><img src='{$docRootURL}media/reference/{$row['image']}' class='img-responsive' align='center' width='225'></td>";
            echo "<td>{$row['notes']}</td>";
            echo "</tr>";
        }
    ?>
    </table>
    
    <a name="Programmers"></a>
    <h1>Programmers <?= Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']) ?></h1>
    <p>These are all the supported programmers in fitPRO.  </p>
    <div class="alert alert-warning" role="alert">NOTE: Not all programmers are supported by all products and cable combinations.  
    Please refer to the <a href="#CableReference">Cable Reference</a> to verify the programmers to use.</div>
    
    <table class="table table-striped">
    <tr><th>Name</th><th>Programmers</th><th>Data Cable</th></tr>
    <?php
        foreach($dataProgBox as $row) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td><img src='{$docRootURL}media/reference/{$row['prog-box-image']}' class='img-responsive' align='center' width='200'></td>";
            echo "<td><img src='{$docRootURL}media/reference/{$row['data-cable-image']}' class='img-responsive' align='center' width='200'>{$row['notes']}</td>";
            echo "</tr>";
        }
    ?>
    </table>
    
    <a name="Housings"></a>
    <h1>Housings <?= Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']) ?></h1>
    <p>These are all the supported housings.  </p>
    <div class="alert alert-warning" role="alert">NOTE: Not all housing are supported by all programmer, connector and cable combinations.  
    Please refer to the <a href="#CableReference">Cable Reference</a> to verify the programmer, connector and cable to use.</div>

    <table class="table table-striped">
    <tr><th>Name</th><th>Type</th><th>Housing</th><th>Connection</th><th>Cable</th><th>Connector</th><th>Notes</th></tr>
    <?php
        foreach($dataHousing as $row) {
            echo "<tr>";
            echo "<td style='width: 100px'>{$row['name']}</td>";
            echo "<td style='width: 100px'>{$row['type']}</td>";
            echo "<td style='width: 150px'><img src='{$docRootURL}media/reference/{$row['image']}' class='img-responsive' align='center' width='150'></td>";
            echo "<td style='width: 225px'><img src='{$docRootURL}media/reference/{$row['connection-image']}' class='img-responsive' align='center' width='225'></td>";
            echo "<td style='width: 100px'>".getCableLabel($row['cable'])."</td>";
            echo "<td>{$row['connector']}</td>";
            echo "<td>{$row['notes']}</td>";
            echo "</tr>";
        }
    ?>
    </table>
    
</div>

<?php
// AJAX logic for Cable Wizard
$jsBlock = <<< JS
    // Subscribe events to #idProductList 
    $('#idProductList').click(function() {
        getProductCableData();
    });
    $('#idProductList').change(function() {
        getProductCableData();
    });
    
    function getProductCableData()
    {
        $.ajax({
            url: 'cable-reference-ajax',
            data: {
                product: $('#idProductList').val(),
            },
            type: 'POST',
            cache: false,
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                } else if(data) {
                    $('#product_search_results').html(data);
                } else {
                    $('#product_search_results').html("Response in invalid format!");
                    alert("Response in invalid format!");
                }
            }
        })
    }
JS;

// NOTE: $position can be:
//   View::POS_READY (the default)
//   View::POS_HEAD 
//   View::POS_BEGIN
//   View::POS_END
$position = \yii\web\View::POS_END;
$this->registerJs($jsBlock, $position);
?>

<?php
//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getCableLabel($cableType) 
{
  switch($cableType) {
    case 'Gray-3x':
		//$label = getCableLabel('Gray-4x'). '<br/><span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span>';
        $label = '<span class="label label-color" style="background-color: #7d7d7d; color: yellow;">Gray-3x</span>';
        break;

    case 'Gray-4x':
        $label = '<span class="label label-color" style="background-color: #7d7d7d; color: #fff;">Gray-4x</span>';
        break;
        
    case 'Black-5x':
        $label = '<span class="label label-color" style="background-color: #000000; color: #fff;">Black-5x</span>';
        break;
        
    case 'Cable Pill 10A':
        // recursively call this function to get Left and Right labels
        $label = getCableLabel($cableType . ' Left') . getCableLabel($cableType . ' Right');
        break;
        
    case 'Cable Pill 10A Left':
        $label  = '<span class="label label-color" style="background-color: #0000ff; color: #fff;"><span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span> Left</span><br>';
        break;

    case 'Cable Pill 10A Right':
        $label = '<span class="label label-color" style="background-color: #ff0000; color: #fff;"><span class="label label-color" style="background-color: #FFD700; color: black;">Cable Pill 10A</span> Right</span>';
        break;
        
    default:
        $label = '<span class="label label-color" style="background-color: #ff0000; color: #fff;">Unknown</span>';
        break;
  }
  return ($label); 
}

function getProductsForListBox($data)
{
    //$arr = ['' => '--- Select One ---'];  // init for combobox
    $arr = [];  // init for listbox
    foreach($data as $key => $row) {
        $arr[$row['product']] = $row['product'] . ' | ' . $row['housing'];
    } 
    return $arr;
}
?>