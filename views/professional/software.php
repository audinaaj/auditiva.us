<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;
use app\models\UtilsFitpro;

/* @var $this yii\web\View */
$this->title = 'Software';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    <img src="<?= Yii::$app->homeUrl; ?>img/professionals/banner-programing-software.jpg" class="img-responsive" align="center" width="1140">
    
    <p>&nbsp;</p>
    
    <div class="row">
    
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">fitPRO 2022</div>
                <div class="panel-body">
                    <p>For fitting and programming all the latest <?= Yii::$app->params['companyNameShort'] ?> products.<!-- It includes:
                      <ul>
                      <li>Stand-alone.</li>
                      <li>HI-PRO, NOAHlink, and EMiniTec drivers.</li>
                      </ul> -->
                    </p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-default btn-md btn-block" data-toggle="modal" data-target="#modalSwReq">
                      <span class="glyphicon glyphicon-info-sign"></span> View Requirements
                    </button>
                    <?= Html::a('<i class="glyphicon glyphicon-info-sign d-icon"></i>' . ' View Cable Reference', 
                         ['cable-reference'], ['class'=>'btn btn-default btn-block']) 
                    ?>
                    <?= getSoftwareDownloadButton(
                        //'Download fitPRO ' . date('Y'), 
                        'Download fitPRO 2022', 
                        'https://cdn.auditiva.us/fitpro-Auditiva-2022-latest.exe',
                        'success'
                    ) ?>

                    <?php
                        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role <= User::ROLE_ADMIN)
                        {
                            $code = UtilsFitpro::CalcTempUnlockCode(new \DateTimeImmutable("now"));
                            $tooltip = $code.' <a class="btn btn-default btn-clip" data-clipboard-text="'.$code.'"><i class="glyphicon glyphicon-copy d-icon"></i></a>';

                            echo '<div class="auditiva-tooltip">' .
                                Html::a("Need a 'Today' code?", ['professional/fitpro']) .
                                Html::tag('div', $tooltip, ['class' => 'tooltiptext']) .
                                '</div>';
                        }
                    ?>

                    <!-- Modal -->
                    <div class="modal fade" id="modalSwReq" tabindex="-1" role="dialog" aria-labelledby="lblModalSwReq">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="lblModalSwReq">Software Requirements</h4>
                          </div>
                          <div class="modal-body">
                                <?= $this->render('_software-requirements') ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">fitPRO for Legacy Products</div>
                <div class="panel-body">
                    <p>For programming older products (sold before 2011) that have been discontinued.<!-- It includes:
                      <ul>
                      <li>Stand-alone.</li>
                      <li>HI-PRO, NOAHlink, and EMiniTec drivers.</li>
                      </ul> -->
                    </p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-default btn-md btn-block" data-toggle="modal" data-target="#modalSwReq">
                      <span class="glyphicon glyphicon-info-sign"></span> View Requirements
                    </button>
                    <?= getSoftwareDownloadButton(
                        'Download fitPRO 4.30', 
                        'https://cdn.auditiva.us/fitpro430-auditiva-intl.exe'
                    ) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Cable Reference</div>
                <div class="panel-body">
                    <p>For programmable products using fitPRO, you must select the correct cable and connector for the product. </p> 
                    <?= Html::a('<i class="glyphicon glyphicon-info-sign d-icon"></i>' . ' View Cable Reference', 
                         ['cable-reference'], ['class'=>'btn btn-default btn-block']) 
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <h3>Other</h3>
            <p>Only required for local network installations when sharing a single patient database among several workstations.</p>
            <ul>
                <li><a href="https://cdn.auditiva.us/Firebird-2.5.9.27139_0_x64.exe">Firebird Database Server</a> (9.6 MB)</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Drivers</h3>
            <p>For specific drivers when using USB-Serial Adapters and Programming Interfaces:</p>
            <ul>
                <li><a href="drivers">Drivers</a></li>
                <li><a href="http://www.himsa.com/Download/NOAHlinkUpdatesandPatches/NOAHlinkUpdate/tabid/485/language/en-US/Default.aspx">NOAHlink</a></li>
            </ul>
        </div>
    </div>
</div>

<?php
function getSoftwareDownloadDisclaimer()
{
    $msg = '';
    if (!isset(Yii::$app->user->identity)) {
        $msg .= '<p>';
        $msg .= '<div class="alert alert-danger" role="alert"><small>';
        $msg .= '<strong>THIS SOFTWARE IS FOR HEARING CARE PROFESSIONAL USE ONLY.</strong>  The use of this software by unqualified persons 
        as a non-hearing care professional can result in personal injury. ';
        $msg .= Yii::$app->params['companyName'] . ' is exempt from any liability which occurs by such unauthorized use.';
        $msg .= '</small></div>';
    }
    return $msg;
}

function getSoftwareDownloadButton($buttonLabel, $fileToDownload, $color='default')
{
    $str = '';
    
    // Provide simple link to logged in users, but a disclaimer modal window for unauthenticated users
    if (isset(Yii::$app->user->identity)) {
        //-------------------------------
        // For Authenticated Users
        //-------------------------------
        $str = Html::a('<i class="glyphicon glyphicon-download-alt d-icon"></i> ' . $buttonLabel, 
            $fileToDownload,  //Yii::$app->params['companyWebsite'].'/downloads/fitpro/fitpro-Audina-' . date('Y') . '-latest.exe', 
            ['class'=>"btn btn-{$color} btn-block"]
        );
    } else {
        //-------------------------------
        // For Unauthenticated Users
        //-------------------------------
        $modalName = 'modal' . str_replace(" ", "_", $buttonLabel);  // replace spaces with underscores
        $modalName = str_replace(".", "_", $modalName);              // replace period with underscores
        $modalName = str_replace("(", "_", $modalName);              // replace parenthesis with underscores
        $modalName = str_replace(")", "_", $modalName);              // replace parenthesis with underscores
        
        // Button definition
        $str .= '<!-- Button trigger modal -->';
        $str .= '<button type="button" class="btn btn-'.$color.' btn-md btn-block" data-toggle="modal" data-target="#'. $modalName . '">';
        $str .= '  <i class="glyphicon glyphicon-download-alt d-icon"></i> ' . $buttonLabel;
        $str .= '</button>';
        $str .= "";

        // Modal window definition
        $str .= '<!-- Modal -->';
        $str .= '<div class="modal fade" id="'. $modalName . '" tabindex="-1" role="dialog" aria-labelledby="'. $modalName . 'Label">';
        $str .= '  <div class="modal-dialog" role="document">';
        $str .= '    <div class="modal-content">';
        $str .= '      <div class="modal-header">';
        $str .= '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $str .= '        <h4 class="modal-title" id="'. $modalName . 'Label">'. $buttonLabel . '</h4>';
        $str .= '      </div>';
        $str .= '      <div class="modal-body">';
        $str .= '        <div class="alert alert-danger" role="alert"><small><strong>THIS SOFTWARE IS FOR HEARING CARE PROFESSIONAL USE ONLY.</strong> The use of this software by unqualified persons as a non-hearing care professional can result in personal injury. ' . Yii::$app->params['companyName'] . ' is exempt from any liability which occurs by such unauthorized use.</small></div>';
        $str .= '      </div>';
        $str .= '      <div class="modal-footer">';
        $str .= '        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
        $str .= Html::a('<i class="glyphicon glyphicon-download-alt d-icon"></i>' . ' Download', $fileToDownload, ['class'=>'btn btn-success']);
        $str .= '      </div>';
        $str .= '    </div>';
        $str .= '  </div>';
        $str .= '</div>';
    }
    
    return $str;
}
?>