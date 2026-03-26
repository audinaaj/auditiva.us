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
    <?php
    //$baseUrl = Yii::$app->request->baseUrl . '/media/brochure';
    $baseUrl = Yii::$app->urlManager->createUrl('') . 'media/brochure';
    
    //echo '<pre>Files found: ' . print_r($files, true) . '</pre>';
    GenFileListTable($dirBrochure, $filesBrochure, $baseUrl, $ShowAllProducts /* show current & deprecated products? */);
    ?>
    
    <h1>User Manuals</h1>
    
    <p>Select the appropriate button below to download a PDF of our latest product user manual:</p>
    <?php
    //$baseUrl = Yii::$app->request->baseUrl . '/media/brochure';
    $baseUrl = Yii::$app->urlManager->createUrl('') . 'media/usermanual';
    
    //echo '<pre>Files found: ' . print_r($files, true) . '</pre>';
    GenFileListTable($dirUserManual, $filesUserManual, $baseUrl, $ShowAllProducts /* show current & deprecated products? */);
    ?>

</div>

<?php
//-------------------------------------------------------------------------------------------------
// description: Generate a HTML table with hyperlinks to files.
// parameters : $aBaseDir (eg: "/catalog", $aFileList (list of filenames)
//              $aFileList, $aTargetBaseURL, $ShowDeprecated
// return     : void
//-------------------------------------------------------------------------------------------------
function GenFileListTable($aBaseDir, $aFileList, $aTargetBaseURL, $ShowDeprecated)
{
    $aBaseDir = rtrim($aBaseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;  // add trailing slash
    $lastprodNameAndStyles = "";
    
    echo '<table class="table table-striped">';
    // Header
    echo '<tr><th>Product</th><th colspan="3">Document</th></tr>';
    
    $totalfiles = count($aFileList);
    for($i=0, $row=0; $i < $totalfiles; $i++)
    {
        $curprodNameAndStyles = substr(pathinfo($aFileList[$i], PATHINFO_FILENAME), 0 /* start pos */, -3 /* remove lang code at end */);
        if ($curprodNameAndStyles != $lastprodNameAndStyles)
        {
            // get product hyperlinks
            $prodstyles = array();
            $fullpath     = $aBaseDir . $aFileList[$i];
            $filelink_en  = SetLinkToFile($fullpath, $aTargetBaseURL, ENGLISH);
            $filelink_es  = SetLinkToFile($fullpath, $aTargetBaseURL, SPANISH);
            $filelink_de  = SetLinkToFile($fullpath, $aTargetBaseURL, GERMAN);
            $prodstyles = explode('-', $curprodNameAndStyles);
            
            // get filters
            $IsProductFamily = (strpos($curprodNameAndStyles, "(Family)") != false);
            if ($IsProductFamily)
            {
                $prodstyles[] = "Family";  // It is a product family.  Let's add it to product styles array so it can be detected.
            }
            $IsDeprecated = in_array("deprecated",   $prodstyles);
            
            $prodName = ($IsDeprecated ? "<del><font color='gray'>" : "" ) . $prodstyles[0] . ($IsDeprecated ? " (Discountinued)</font></del>" : "" );
            
            // generate row
            if ( (!$IsDeprecated) || ($IsDeprecated && $ShowDeprecated))
            {
                // get row color
                if ($row % 2 == 0)
                {
                    $rowcolor = "#dedede";
                } else {
                    $rowcolor = "#f5f5f5";
                }
                $row++;

                // print row
                //echo '<tr bgcolor="' . $rowcolor . '">';
                echo '<tr bgcolor="' . $rowcolor . '">';
                echo '<td>' . $prodName . '</td>';
                echo '<td>' . $filelink_en . '</td>';
                echo '<td>' . $filelink_es . '</td>';
                //echo '<td>' . $filelink_de . '</td>';
                echo '</tr>'."\n";
            }
        }
        $lastprodNameAndStyles = $curprodNameAndStyles;
    }
    echo '</table>';
}

//-------------------------------------------------------------------------------------------------
// description: Set the appropriate file link if file is available.
// parameters : $aFilePath (eg: "C:/www/catalog/flx-OTE-en.pdf"), $Language (eg: "ENGLISH", "SPANISH", etc.)
// return     : $str (a string with the hyperlink)
//-------------------------------------------------------------------------------------------------
function SetLinkToFile($aFilePath, $aTargetBaseURL, $Language)
{
    $DS = DIRECTORY_SEPARATOR;
    $dirname  = pathinfo($aFilePath, PATHINFO_DIRNAME );   // native path with no filename. Eg: C:\wamp\www\site\web\media
    $basename = pathinfo($aFilePath, PATHINFO_BASENAME );  // filename with extension. Eg: prod.pdf
    $filename = pathinfo($aFilePath, PATHINFO_FILENAME );  // filename without extension. Eg: prod
    $extname  = pathinfo($aFilePath, PATHINFO_EXTENSION ); // file extension name. Eg: pdf
    
    // Get filename without language code (eg: -en, -es, etc.)
    $prodName     = substr($filename, 0 /* start pos */, -3 /* remove lang code at end */);  // Eg: remove '-en' or '-es'
    $prodFullPath = $dirname . $DS . $prodName . '-' . GetLanguageSuffix($Language) . '.' . $extname;
    $prodFileName = $prodName . '-' . GetLanguageSuffix($Language) . '.' . $extname;
    $prodFileURL  = $aTargetBaseURL . '/'. $prodFileName;
    
    $LinkLabel = GetLanguageHTMLString($Language);
    
    //echo '<br/><br/>dirname='.$dirname;
    //echo '<br/>basename='.$basename;
    //echo '<br/>filename='.$filename;
    //echo '<br/>prodFullPath='.$prodFullPath;
    //echo '<br/>prodFileName='.$prodFileName;
    //echo '<br/>webroot='.Yii::getAlias('@webroot');
    //echo '<br/>prodFileURL='.$prodFileURL;
    
    if (file_exists($prodFullPath)) {
        $str = "<a href='$prodFileURL' class='btn btn-primary' target='_blank'>$LinkLabel</a>";
    } else {
        $str =  "<a href='#' class='btn btn-default disabled'>$LinkLabel </a>";
    }
    return $str;
}

//-------------------------------------------------------------------------------------------------
// description:
// parameters :
// return     :
//-------------------------------------------------------------------------------------------------
function GetLanguageHTMLString($Language)
{
    switch($Language) {
        case SPANISH:
            return "Espa&ntilde;ol";
            
        case GERMAN:
            return "Deutsch";
            
        default:    
        case ENGLISH:
            return "English";
    }
}

//-------------------------------------------------------------------------------------------------
// description:
// parameters :
// return     :
//-------------------------------------------------------------------------------------------------
function GetLanguageSuffix($Language)
{
    switch($Language) {
        case SPANISH:
            return "es";
            
        case GERMAN:
            return "de";
            
        default:    
        case ENGLISH:
            return "en";
    }
}
?>