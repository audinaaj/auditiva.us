<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Marketing Materials';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

$docRootURL = Yii::$app->urlManager->createUrl('web');
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    <img src="<?= Yii::$app->homeUrl; ?>img/professionals/banner-marketing.jpg" class="img-responsive" align="center" width="1140">
    
    <p>&nbsp;</p>
    <div class="col-lg-6">
        <h3>Graphic Standards</h3>
        Download the following by right-click, "Save As":
        <ul>
            <li><a href="<?= $docRootURL ?>/media/marketing/Auditiva-GraphicStandardsManual-v20160126.pdf" target="_blank">Graphic Standards Manual (2016-01-26)</a></li>
        </ul>
    </div>
    
    <div class="col-lg-6">
        <h3>Product Logos</h3>
        Click on a link below to download zip compressed archive of our product and company logos 
        (formats include: eps, jpg, tif for both b&w and color)
        <ul>
        <?php
            $files = array();
            $folders = array();
            $targeturl = $docRootURL."/media/marketing/product-logos";
            getFileAndFolderList($targeturl, "zip", $files, $folders);
            //echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
            
            foreach($files as $file) {
                echo '<li><a href="' . $targeturl . '/' . $file . '">' . substr($file, 0, -4) . '</a></li>';
            }
        ?>
        </ul>
    </div>
    
    <div class="col-lg-6">
        <h3>Product Brochures</h3>
        Click on a link below to download a pdf of our latest product brochure
        <ul>
        <?php
            $files = array();
            $folders = array();
            $targeturl = $docRootURL."/media/marketing/product-brochures";
            getFileAndFolderList($targeturl, "pdf", $files, $folders);
            //echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
            
            foreach($files as $file) {
                echo '<li><a href="' . $targeturl . '/' . $file . '">' . ucwords(substr($file, 0, -4)) . '</a></li>';
            }
        ?>
        </ul>
    </div>
    
    <div class="col-lg-6">
        <h3>Product Images</h3>
        Click on a link below to download zip compressed archive of our product and company images
        (formats include: jpg)
        <ul>
        <?php
            $files = array();
            $folders = array();
            $targeturl = $docRootURL."/media/marketing/product-images";
            getFileAndFolderList($targeturl, "zip", $files, $folders);
            //echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
            
            foreach($files as $file) {
                echo '<li><a href="' . $targeturl . '/' . $file . '">' . ucwords(substr($file, 0, -4)) . '</a></li>';
            }
        ?>
        </ul>
    </div>
    
    <div class="col-lg-6">
        <?php //echo Html::a('<i class="glyphicon glyphicon-picture d-icon"></i>' . ' Browse', 
              //Yii::$app->params['companyWebsite'] ."/download/marketing-assets/filemanager/dialog.php?type=0&editor=mce_0", 
              //['class'=>'btn btn-warning', 'target' => '_blank']) 
        ?>
    </div>

</div>

<?php
//-------------------------------------------------------------------------------------------------
// description: Get file and folder list for the specified path (filtered by the specified extension).
//              Eg: 
//                $files = array();
//                $folders = array();
//                getFileAndFolderList("/catalog", "pdf", $files, $folders);
//                echo "<br><pre>" . print_r($files, true) . "</pre><p>"; 
// parameters : $atargeturl (no trailing slash), $aFileType (no leading dot), $Files_Result (output array), $Folders_Result (output array)
// return     : void
//-------------------------------------------------------------------------------------------------
function getFileAndFolderList($atargeturl, $aFileType, &$Files_Result, &$Folders_Result)
{
    clearstatcache();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $Folders_Result = array();
    $Files_Result   = array();
    if (is_dir($_SERVER["DOCUMENT_ROOT"] . $atargeturl)) {
        $dirhandle = opendir($_SERVER["DOCUMENT_ROOT"] . $atargeturl);
        
        for($i=0; (($file = readdir($dirhandle)) !== false); $i++) {
            if ($file != "." and $file != "..") {
                if (is_file($file)) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    //$filename = pathinfo($file, PATHINFO_FILENAME); 
                    if ($ext == $aFileType) {
                        $Files_Result[] = $file;
                    }
                } else if (is_dir($file)) {
                    $Folders_Result[] = $file;
                } else if (is_link($file)) {
                    $Folders_Result[] = $file;
                } else {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if ($ext == $aFileType) {
                        $Files_Result[] = $file;
                    }
                }
            }
        }
        closedir($dirhandle);
        
        // sort, just in case
        if (defined('SORT_NATURAL')) { // supported in PHP 5.4.0 or newer only
            if (isset($Files_Result))   { sort($Files_Result,   SORT_NATURAL | SORT_FLAG_CASE); }
            if (isset($Folders_Result)) { sort($Folders_Result, SORT_NATURAL | SORT_FLAG_CASE); }
        } else {
            if (isset($Files_Result))   { sort($Files_Result,   SORT_STRING); }
            if (isset($Folders_Result)) { sort($Folders_Result, SORT_STRING); }
        }
    }
}
?>
