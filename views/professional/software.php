<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

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
                <div class="panel-body">
                    <h3>fitPRO <?= '2018';//date('Y') ?></h3>
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
                        'Download fitPRO 2018', 
                        Yii::$app->params['companyWebsite'].'/downloads/fitpro/fitpro-Auditiva-2018-latest.exe',
                        //Yii::$app->params['companyWebsite'].'/downloads/fitpro/fitpro-Auditiva-' . date('Y') . '-latest.exe',
                        'success'
                    ) ?>

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
                <div class="panel-body">
                    <h3>fitPRO for Legacy Products</h3>
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
                        Yii::$app->params['companyWebsite'].'/downloads/fitpro430-auditiva-intl.exe'
                    ) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Remote Support</h3>
                    <p>If calling for support and advised to do so, download this remote support utility. </p> 
                    <?= Html::a('<i class="glyphicon glyphicon-download-alt d-icon"></i>' . ' Remote Support', 
                         Yii::$app->params['companyWebsite'].'/downloads/remote-support/AnyDesk.exe',
                         ['class'=>'btn btn-warning btn-block', 'target' => '_blank']) 
                    ?>
                    <?= Html::a('<i class="glyphicon glyphicon-download-alt d-icon"></i>' . ' Remote Support 2', 
                         'https://get.teamviewer.com/auditiva',
                         ['class'=>'btn btn-default btn-block', 'target' => '_self']) 
                    ?>
                    
                    <h3>Cable Reference</h3>
                    <p>For programmable products using fitPRO, you must select the correct cable and connector for the product. </p> 
                    <?= Html::a('<i class="glyphicon glyphicon-info-sign d-icon"></i>' . ' View Cable Reference', 
                         ['cable-reference'], ['class'=>'btn btn-default btn-block']) 
                    ?>
                </div>
            </div>
        </div>
    
    </div>
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    
    <div class="row">
    
        <div class="col-md-6">
        
            <h3>Other</h3>
            <p>Only required for local network installations when sharing a single patient database among several workstations.</p>
            <ul>
                <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/FBserver-setup.exe">Firebird Webinstaller</a> (0.5 MB) - Autodetects 32/64-bit requirements</li>
                <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/Firebird-2.5.2.26540_0_Win32.exe">Firebird Database Server (32-bit)</a></li>
                <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/Firebird-2.5.2.26540_0_x64.exe">Firebird Database Server (64-bit)</a></li>
            </ul>

            <h3>Drivers</h3>
            <p>For specific drivers when using USB-Serial Adapters and Programming Interfaces:</p>
            <ul>
                <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/drivers/">Drivers</a></li>
                <li><a href="http://www.himsa.com/Download/NOAHlinkUpdatesandPatches/NOAHlinkUpdate/tabid/485/language/en-US/Default.aspx">NOAHlink</a></li>
            </ul>
            
        </div>

        <div class="col-md-6">
        
            <h3>Requirements</h3>
            <p>.NET 4.0 Framework</p>
            <ul>
                <li><a href="http://www.microsoft.com/en-us/download/details.aspx?id=17718">Standalone Installer (Microsoft)</a> (49 MB)</li>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/dotNetFx40_Full_x86_x64.exe">Standalone Installer (Mirror)</a> (49 MB)</li>
                <?php endif; ?>
                <li><a href="https://www.microsoft.com/en-us/download/details.aspx?id=29053">32-bit/64-bit: Update 4.0.3 for Microsoft .NET Framework 4 (KB2600211) (Microsoft)</a> (43 MB)</li>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP40-KB2600211-x86.exe">32-bit: Update 4.0.3 for Microsoft .NET Framework 4 (KB2600211) (Mirror)</a> (43 MB)</li>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP40-KB2600211-x86-x64.exe">64-bit: Update 4.0.3 for Microsoft .NET Framework 4 (KB2600211) (Mirror)</a> (69 MB)</li>
                <?php endif; ?>
                <li><a href="https://www.microsoft.com/en-us/download/details.aspx?id=3556">32-bit/64-bit: Update for Microsoft .NET Framework 4 (KB2468871) (Microsoft)</a> (19/27 MB)</li>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP40-KB2468871-v2-x86.exe">32-bit: Update for Microsoft .NET Framework 4 (KB2468871) (Mirror)</a> (43 MB)</li>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP40-KB2468871-v2-x64.exe">64-bit: Update for Microsoft .NET Framework 4 (KB2468871) (Mirror)</a> (69 MB)</li>
                <?php endif; ?>
            </ul>
            
            <p>.NET Fixes</p>
            <ul>
                <li><a href="http://www.microsoft.com/en-us/download/details.aspx?id=53344">32-bit/64-bit: Update for Windows 8.1 (KB3063843) (Microsoft)</a> (60 MB)</li>
                <li><a href="http://www.microsoft.com/en-us/download/details.aspx?id=53344">32-bit/64-bit: Update for Microsoft .NET Framework 4.6.2 (KB3151800) (Microsoft)</a> (60 MB)</li>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP462-KB3151800-x86-x64-AllOS-ENU.exe">32-bit/64-bit: Update for Microsoft .NET Framework 4.6.2 (KB3151800) (Mirror)</a> (60 MB)</li>
                <?php endif; ?>
                <li><a href="https://www.microsoft.com/en-us/download/confirmation.aspx?id=44928">32-bit/64-bit: Update for Microsoft .NET Framework 4.6 Preview (KB2969353) (Microsoft)</a> (1.2 MB)</li>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/NDP453-KB2969353-Web.exe">32-bit/64-bit: Update for Microsoft .NET Framework 4.6.2 (KB3151800) (Mirror)</a> (60 MB)</li>
                <?php endif; ?>
            </ul>
            <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) : ?>
                <p>Windows XP Service Pack 3 - Only for WinXP users</p>
                <ul>
                  <!-- <li><a href="http://www.microsoft.com/en-us/download/details.aspx?id=24">English (Microsoft)</a> (316 MB)</li> -->
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/WindowsXP-KB936929-SP3-x86-ENU.exe">English (Mirror)</a> (316 MB)</li>
                  <!-- <li><a href="http://www.microsoft.com/es-es/download/details.aspx?id=24">Español (Microsoft)</a> (316 MB)</li> -->
                  <li><a href="<?= Yii::$app->params['companyWebsite'] ?>/downloads/requirements/WindowsXP-KB936929-SP3-x86-ESN.exe">Español (Mirror)</a> (316 MB)</li>
                </ul>
            <?php endif; ?>

        </div>
    </div>
    
    <!-- <div class="col-lg-12">
        <h3>User Documentation</h3>
        <div class="contentpane">
        <iframe 	id="blockrandom"
            name="iframe"
            src="<?= Yii::$app->params['companyWebsite'] ?>/fitprodoc/"
            width="100%"
            height="800"
            scrolling="auto"
            frameborder="1"
            class="wrapper">
            This option will not work correctly. Unfortunately, your browser does not support inline frames.</iframe>
        </div>
    </div> -->

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
        
        // Button definition
        $str .= '<!-- Button trigger modal -->';
        $str .= '<button type="button" class="btn btn-'.$color.' btn-md btn-block" data-toggle="modal" data-target="#'. $modalName . '">';
        $str .= '  <i class="glyphicon glyphicon-download-alt d-icon"></i> ' . $buttonLabel;
        $str .= '</button>';
        $str .= "";
    }
    
    return $str;
}
?>