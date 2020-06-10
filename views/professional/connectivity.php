<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
//use yii\widgets\ListView;

/* @var $this yii\web\View */
$this->title = 'Connectivity Reference';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

$docRootURL = Yii::$app->urlManager->createUrl('');
?>
<div class="professional-cable-reference">
    
    <a name="top"></a>
    <a name="CableReference"></a>
    <h1><?= ''; //$this->title; ?> <?= ''; //Html::a('<i class="glyphicon glyphicon-print d-icon"></i>' . ' Print', ['professional/cable-reference-pdf'], ['class'=>'btn btn-default']) ?>
        <?= ''; //Html::a('Cables',      '#Cables',      ['class'=>'btn btn-default']) ?>
        <?= ''; //Html::a('Connectors',  '#Connectors',  ['class'=>'btn btn-default']) ?>
        <?= ''; //Html::a('Programmers', '#Programmers', ['class'=>'btn btn-default']) ?>
        <?= ''; //Html::a('Housings',    '#Housings',    ['class'=>'btn btn-default']) ?>
    </h1>
    
    <p>
    
    <a name="Cables"></a>
    <h1>Cables <?= Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']) ?></h1>
    <p>These are all the supported Cables.  </p>
    <div class="alert alert-warning" role="alert">NOTE: Not all cables are supported by all products and programming box combinations.  
    Please refer to the <a href="#CableReference">Cable Reference</a> to verify the cable to use.</div>

    <table class="table table-striped">
    <tr><th>Name</th><th>Cable</th><th>Compatibility</th><th>Notes</th></tr>
    <?php
        //foreach($dataCables as $row) {
        //    echo "<tr>";
        //    echo "<td><h3>".getCableLabel($row['name'])."</h3></td>";
        //    echo "<td><img src='{$docRootURL}media/reference/{$row['image']}' class='img-responsive' align='center' width='200'></td>";
        //    echo "<td>{$row['compatible']}</td>";
        //    echo "<td>{$row['notes']}</td>";
        //    echo "</tr>";
        //}
    ?>
    </table>
    <h1>Troubleshooting</h1>
    <p>Possible reasons for not detecting a hearing aid:</p>
    <ol>
        <li>No hearing aids are plugged into the programming box.</li>
        <li>Loose connection to hearing aid or programming box.</li>
        <li>Faulty programming cables or flexstrips.</li>
        <li>Wrong programming cables or flexstrips (only use flexstrips type CS54/XtendPads, 4-pins).</li>
        <li>Programming box may need resetting</li>
        <li>Hearing aid may not be manufactured by this manufacturer.</li>
    </ol>
    <p></p>
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Troubleshoot Programming Box
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <h3>Select Programming Box</h3>
            <div class="list-group">
              <a href="#" class="list-group-item">
                <table>
                <td width="200">
                  <h4 class="list-group-item-heading">HiPro Classic</h4>
                  <p class="list-group-item-text">Serial connection with USB-Serial adapter</p>
                </td>
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-HiPro-Classic.jpg' class='img-responsive' align='center' width='225'></td>
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-data-cable-serial-usbadapter.jpg' class='img-responsive' align='center' width='225'></td>
                </table>
              </a>
              <a href="#" class="list-group-item">
                <table>
                <td width="200">
                  <h4 class="list-group-item-heading">HiPro USB</h4>
                  <p class="list-group-item-text">USB connection</p>
                </td>  
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-HiPro-USB-v1.jpg' class='img-responsive' align='center' width='225'></td>  
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-data-cable-usb.jpg' class='img-responsive' align='center' width='225'></td>  
                </table>
              </a>
              <a href="#" class="list-group-item">
                <table>
                <td width="200">
                  <h4 class="list-group-item-heading">HiPro 2</h4>
                  <p class="list-group-item-text">USB connection</p>
                </td>  
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-HiPro-USB-v2.jpg' class='img-responsive' align='center' width='225'></td>  
                <td><img src='<?= $docRootURL ?>media/reference/ProgBox-data-cable-usb.jpg' class='img-responsive' align='center' width='225'></td>  
                </table>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Troubleshoot Cables &amp; Connectors
            </a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="panel-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
            
            <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
              Popover on left
            </button>

          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingThree">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Troubleshoot Connectivity
            </a>
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
          <div class="panel-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          </div>
        </div>
      </div>
    </div>
    
    
</div>

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
?>