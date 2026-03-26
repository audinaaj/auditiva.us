<?php
use yii\helpers\Html;
use yii\helpers\Url;

//-------------------------------------------------------------------------------------------------
// Constants
//-------------------------------------------------------------------------------------------------
define("ENGLISH", "English");
define("SPANISH", "Spanish");

/* @var $this yii\web\View */
$this->title = 'Product Specifications';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="professional-prod-specs">
       
    <h1><?= $this->title; ?></h1>
    
    <script language="JavaScript" type="text/JavaScript">
        <!--
        function MM_jumpMenu(targ,selObj,restore) //v3.0
        {
          eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
          if (restore) selObj.selectedIndex=0;
        }
        //-->
    </script>
    
    <?php DisplayProductFilter($IsVisibleProductFilter); ?>
    <p>
    
    <p>Select the appropriate button below to download a PDF of our latest product specification sheet:</p>
    
    <?php
    //$baseUrl = Yii::$app->request->baseUrl . '/media/catalog';
    $baseUrl = Yii::$app->urlManager->createUrl('').'media/catalog';
    
    //echo '<pre>Files found: ' . print_r($files, true) . '</pre>';
    GenFileListTable($dir, $files, $baseUrl, $ShowAllProducts /* show current & deprecated products? */, $FilterByStyle);
    ?>

</div>

<?php
//-------------------------------------------------------------------------------------------------
// Description:
// Present table with all supported product specification sheets by reading a directory with
// carefully named files to convey the necessary information to classify products.
//
// Filename Format:
//   <productname>-<styles>[-deprecated]-<languagecode>.pdf
// Format description:
//   <productname> - A string with name of product. Eg:  "Intution 12"
//   <styles>      - A list of string with style names, each separated by a dash (-) with no spaces between. Eg: "IIC-CIC-Canal-HS-FSS-Super60"
//   [-deprecated] - Optional parameter to define whether product has been deprecated.  
//                   When disabling deprecated content, it will not display.  
//                   When enabled, it displays but with strikethrough text.
//   [-intro]      - Optional parameter to define whether document is an introduction doc.  
//   [-misc]       - Optional parameter to define whether document is not a product spec sheet.  
//   <languagecode> - A language code denoting what language is used in document. Eg: "en" for English, "es" for Spanish, etc.
//
//  Eg: 
//     Dir:  /catalog/
//     File: - Intuition 12-IIC-CIC-Canal-HS-FSS-Super60-Super70-en.pdf
//           - Intuition 6-IIC-CIC-HS-Canal-FSS-Super60-Super70-es.pdf
//           - IRIC-Open-en.pdf
//           - Intuition 4-FSS-deprecated-en.pdf  (Deprecated product)
//           - 001 Catalog Cover Letter-intro-en.pdf (Intro document)
//           - Guide for Module Code Ordering-Misc-en.pdf (Misc document)
// Output:
//+--------------------------------------------------------------------------------------------------------------------
//|   Product Specifications                       
//+--------------------------------------------------------------------------------------------------------------------
//|      Supported Styles                          
//+--------------------------------------------------------------------------------------------------------------------
//| Product         Spec Sheet             IIC CIC Canal  HS   FSS Super60 Super70 BTE SuperBTE Open    Stock   Misc   
//+--------------------------------------------------------------------------------------------------------------------
//| Analog AGCO    [ English ] [ Español ]      X   X      X    X                                                      
//| Analog Class A [ English ] [ Español ]      X   X      X    X                                                      
//| Analog Class D [ English ] [ Español ]      X   X      X    X   X                                                  
//| BTE 13 D2      [ English ] [ Español ]                                          X                                  
//| BTE 368        [ English ] [ Español ]                                          X                                  
//+--------------------------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------
// description: Generate a HTML table with hyperlinks to files.
// parameters : $aBaseDir (eg: "/catalog", $aFileList (list of filenames)
//              $aFileList, $aTargetBaseURL, $ShowDeprecated
// return     : void
//-------------------------------------------------------------------------------------------------
function genFileListTable($aBaseDir, $aFileList, $aTargetBaseURL, $ShowDeprecated, $FilterByStyle)
{
    $aBaseDir = rtrim($aBaseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;  // add trailing slash
    $lastprodNameAndStyles = "";
    
    echo '<table class="table table-striped">';
    // Header
    //echo '<tr><th>Product</th><th colspan="2">Specification Sheet</th></tr>';
    //echo '<tr bgcolor="#dedeff"><th>&nbsp;</th><th colspan="2">&nbsp;</th><th colspan="10">Supported Styles</th><th colspan="3">Other</th></tr>';
    //echo '<tr bgcolor="#dedeff"><th>Product</th><th colspan="2">Spec Sheet</th><th>IIC</th><th>CIC</th><th>Canal</th><th>1/2 Shell</th><th>FSS</th><th>Super 60</th><th>Super 70</th><th>BTE</th><th>Super BTE</th><th>Open</th><th>Stock</th><th>Family</th><th>Misc</th></tr>';
    echo '<tr bgcolor="#dedeff"><th>&nbsp;</th><th colspan="2">&nbsp;</th><th colspan="10">Supported Styles</th><th colspan="4">Other</th></tr>';
    echo '<tr bgcolor="#dedeff"><th>Product / Document Name</th><th colspan="2">Spec Sheet / Doc</th><th>IIC</th><th>CIC</th><th>Canal</th><th>1/2 Shell</th><th>FSS</th><th>Super 60</th><th>Super 70</th><th>BTE</th><th>Super BTE</th><th>Open</th><th>Stock</th><th>Family</th><th>Misc</th><th>Intro Docs</th></tr>';
    
    $totalfiles = count($aFileList);
    for($i=0, $row=0; $i < $totalfiles; $i++) {
        
        // Do not process 'blank.pdf' file
        if ($aFileList[$i] == 'blank.pdf') {
            continue;  // Skip.  
        }
        
        $curProdNameAndStyles = substr(pathinfo($aFileList[$i], PATHINFO_FILENAME), 0 /* start pos */, -3 /* remove lang code at end */);
        if ($curProdNameAndStyles != $lastprodNameAndStyles) {
            // get product hyperlinks
            $prodStyles  = array();
            $fullpath    = $aBaseDir . $aFileList[$i];
            $filelink_en = setLinkToFile($fullpath, $aTargetBaseURL, ENGLISH);
            $filelink_es = setLinkToFile($fullpath, $aTargetBaseURL, SPANISH);
            $prodStyles  = explode('-', $curProdNameAndStyles);
            
            // get filters
            $isProductFamily = (strpos($curProdNameAndStyles, "(Family)") != false);
            if ($isProductFamily) {
                $prodStyles[] = "Family";  // It is a product family.  Let's add it to product styles array so it can be detected.
            }
            $IsDeprecated = in_array("deprecated",   $prodStyles);
            
            if (empty($FilterByStyle) || $FilterByStyle == 'All') {
                $IsStyleSupported = true;
            } else {
                $IsStyleSupported = in_array($FilterByStyle, $prodStyles);
            }
            
            $prodName = ($IsDeprecated ? "<del><font color='gray'>" : "" ) . $prodStyles[0] . ($IsDeprecated ? " (Discountinued)</font></del>" : "" );
            
            $IsIntroDoc = in_array("intro", $prodStyles);
            
            // generate row
            if ( ((!$IsDeprecated) || ($IsDeprecated && $ShowDeprecated)) && $IsStyleSupported) {
                // get row color
                if ($row % 2 == 0) {
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
                echo GetProductStylesListInHTMLCells($curProdNameAndStyles, $rowcolor);
                echo '</tr>'."\n";
            }
        }
        $lastprodNameAndStyles = $curProdNameAndStyles;
    }
    echo '</table>';
}

//-------------------------------------------------------------------------------------------------
// description: Set the appropriate file link if file is available.
// parameters : $aFilePath (eg: "C:/www/catalog/flx-OTE-en.pdf"), $Language (eg: "ENGLISH", "SPANISH", etc.)
// return     : $str (a string with the hyperlink)
//-------------------------------------------------------------------------------------------------
function setLinkToFile($aFilePath, $aTargetBaseURL, $Language)
{
    $DS = DIRECTORY_SEPARATOR;
    $dirname  = pathinfo($aFilePath, PATHINFO_DIRNAME );   // native path with no filename. Eg: C:\wamp\www\site\web\media
    $basename = pathinfo($aFilePath, PATHINFO_BASENAME );  // filename with extension. Eg: prod.pdf
    $filename = pathinfo($aFilePath, PATHINFO_FILENAME );  // filename without extension. Eg: prod
    $extname  = pathinfo($aFilePath, PATHINFO_EXTENSION ); // file extension name. Eg: pdf
    
    // Get filename without language code (eg: -en, -es, etc.)
    $prodName     = substr($filename, 0 /* start pos */, -3 /* remove lang code at end */);  // Eg: remove '-en' or '-es'
    $prodFileName = $prodName . '-' . GetLanguageSuffix($Language) . '.' . $extname;
    $prodFullPath = $dirname  . $DS . $prodName . '-' . GetLanguageSuffix($Language) . '.' . $extname;
    $prodFileURL  = $aTargetBaseURL . $DS. $prodFileName;
    
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
        $str = "<a href='#' class='btn btn-default disabled'>$LinkLabel</a>";
    }
    return $str;
}

//-------------------------------------------------------------------------------------------------
// description: 
// parameters : 
// return     : 
//-------------------------------------------------------------------------------------------------
function getProductStylesList($aProdNameAndStyles)
{
    // Get Styles
    $prodStyles = explode( '-', $aProdNameAndStyles); 
    //echo print_r($prodStyles, true); // debug
    
    // Concatenate styles into string
    $stylelist = "";
    $totalStyles = count($prodStyles);
    for($i=1; $i<$totalStyles; $i++) {
        if ($prodStyles[$i] != 'deprecated') {
            $stylelist .= $prodStyles[$i];  // add style
            $stylelist .= ( (($i+1)<$totalStyles) && ($prodStyles[$i+1] != 'deprecated') ? ", " : "");  // add comma if not end (except when next is 'deprecated')
        }
    }
    
    return $stylelist;
}

//-------------------------------------------------------------------------------------------------
// description: 
// parameters : 
// return     : 
//-------------------------------------------------------------------------------------------------
function getProductStylesListInHTMLCells($aProdNameAndStyles, $rowcolor)
{
    // Get Styles
    $prodStyles = explode( '-', $aProdNameAndStyles); 
    //echo print_r($prodStyles[0], true); // debug
    
    if ($rowcolor == "#dedede") {
        $isStrongColor = true;
    } else {
        $isStrongColor = false;
    }
    $iconCheck = '<i class="glyphicon glyphicon-ok d-icon"/>';
    
    $IsIIC        = (in_array("IIC",     $prodStyles) ? $iconCheck : "&nbsp;" );  // Invisible-In-Canal
    $IsCIC        = (in_array("CIC",     $prodStyles) ? $iconCheck : "&nbsp;" );  // Completely-In-Canal
    $IsCanal      = (in_array("Canal",   $prodStyles) ? $iconCheck : "&nbsp;" );  // Mini Canal / Canal
    $IsHS         = (in_array("HS",      $prodStyles) ? $iconCheck : "&nbsp;" );  // Half-Shell
    $IsFSS        = (in_array("FSS",     $prodStyles) ? $iconCheck : "&nbsp;" );  // Full-Shell
    $IsSuper60    = (in_array("Super60", $prodStyles) ? $iconCheck : "&nbsp;" );  // Super60
    $IsSuper70    = (in_array("Super70", $prodStyles) ? $iconCheck : "&nbsp;" );  // Super70
    $IsBTE        = (in_array("BTE",     $prodStyles) ? $iconCheck : "&nbsp;" );  // Behind-The-Ear (BTE)
    $IsSuperBTE   = (in_array("SuperBTE",$prodStyles) ? $iconCheck : "&nbsp;" );  // Super BTE
    $IsOpen       = (in_array("Open",    $prodStyles) ? $iconCheck : "&nbsp;" );  // Over-The-Ear (OTE) / Open
    $IsStock      = (in_array("Stock",   $prodStyles) ? $iconCheck : "&nbsp;" );  // Stock (non-custom)
    $IsProdFamily = ((strpos($aProdNameAndStyles, "(Family)") != false)? $iconCheck : "&nbsp;" );  // Product Family
    $IsMisc       = (in_array("Misc",    $prodStyles) ? $iconCheck : "&nbsp;" );  // Miscellaneous
    $IsIntro      = (in_array("Intro",   $prodStyles) ? $iconCheck : "&nbsp;" );  // Intro Doc
    
    $colorIIC        = ($isStrongColor ? '#FFBF7D' : '#FFF2E5');
    $colorCIC        = ($isStrongColor ? '#FFEE72' : '#FFFCE7');
    $colorCanal      = ($isStrongColor ? '#B5FF9C' : '#F3FFEF');
    $colorHS         = ($isStrongColor ? '#72FFFF' : '#E7FFFF');
    $colorFSS        = ($isStrongColor ? '#8EAAFF' : '#ECF1FF');
    $colorSuper60    = ($isStrongColor ? '#C78EFF' : '#F6ECFF');
    $colorSuper70    = ($isStrongColor ? '#B260FF' : '#F6ECFF');
    $colorBTE        = ($isStrongColor ? '#FFAAFF' : '#FFF1FF');
    $colorSuperBTE   = ($isStrongColor ? '#FF7272' : '#FFE7E7');
    $colorOpen       = ($isStrongColor ? '#FFAAFF' : '#FFF1FF');
    $colorStock      = ($isStrongColor ? '#FF9CB5' : '#FFEFF3');
    $colorProdFamily = ($isStrongColor ? '#D8BFD8' : '#F2EAF2');
    $colorMisc       = $rowcolor; // or choose more colors from http://www.isdntek.com/demo/internetcolors.htm
    $colorIntro      = $rowcolor; // or choose more colors from http://www.isdntek.com/demo/internetcolors.htm
    
    $str  = "";
    $str .= "<td align='center' style='background-color:$colorIIC'>$IsIIC</td>";
    $str .= "<td align='center' style='background-color:$colorCIC'>$IsCIC</td>";
    $str .= "<td align='center' style='background-color:$colorCanal'>$IsCanal</td>";
    $str .= "<td align='center' style='background-color:$colorHS'>$IsHS</td>";
    $str .= "<td align='center' style='background-color:$colorFSS'>$IsFSS</td>";
    $str .= "<td align='center' style='background-color:$colorSuper60'>$IsSuper60</td>";
    $str .= "<td align='center' style='background-color:$colorSuper70'>$IsSuper70</td>";
    $str .= "<td align='center' style='background-color:$colorBTE'>$IsBTE</td>";
    $str .= "<td align='center' style='background-color:$colorSuperBTE'>$IsSuperBTE</td>";
    $str .= "<td align='center' style='background-color:$colorOpen'>$IsOpen</td>";
    $str .= "<td align='center' style='background-color:$colorStock'>$IsStock</td>";
    $str .= "<td align='center' style='background-color:$colorProdFamily'>$IsProdFamily</td>";
    $str .= "<td align='center' style='background-color:$colorMisc'>$IsMisc</td>";
    $str .= "<td align='center' style='background-color:$colorIntro'>$IsIntro</td>";
    return $str;
}

//-------------------------------------------------------------------------------------------------
// description: Display product filter.
// parameters : $IsVisible (true to display, false to hide).
// return     : void
//-------------------------------------------------------------------------------------------------
function displayProductFilter($IsVisible=true)
{
    $curViewID = Yii::$app->view->context->action->id;  // For view 'professional/product-specs', the view ID = 'product-specs'
    
    if ($IsVisible):
    ?>
        <form name="formFilterSelection" id="search">
          Display Filter 
          <select name="menuFilterSelection" id="menuFilterSelection" onChange="MM_jumpMenu('parent',this,0)">
            <option value="<?= $curViewID ?>?showall=0" <?php echo ((isset($_GET['style']) && $_GET['style']=='')? 'selected' : ''); ?> >Current Products</option>
            <option value="<?= $curViewID ?>?showall=1&style=All" <?php echo ((isset($_GET['style']) && $_GET['style']=='All')? 'selected' : ''); ?> >Current &amp; Discontinued Products</option>
            <option value="<?= $curViewID ?>?style=IIC"      <?php echo ((isset($_GET['style']) && $_GET['style']=='IIC')?      'selected' : ''); ?> >IIC</option>
            <option value="<?= $curViewID ?>?style=CIC"      <?php echo ((isset($_GET['style']) && $_GET['style']=='CIC')?      'selected' : ''); ?> >CIC</option>
            <option value="<?= $curViewID ?>?style=Canal"    <?php echo ((isset($_GET['style']) && $_GET['style']=='Canal')?    'selected' : ''); ?> >Canal</option>
            <option value="<?= $curViewID ?>?style=HS"       <?php echo ((isset($_GET['style']) && $_GET['style']=='HS')?       'selected' : ''); ?> >Half Shell</option>
            <option value="<?= $curViewID ?>?style=FSS"      <?php echo ((isset($_GET['style']) && $_GET['style']=='FSS')?      'selected' : ''); ?> >Full Shell</option>
            <option value="<?= $curViewID ?>?style=Super60"  <?php echo ((isset($_GET['style']) && $_GET['style']=='Super60')?  'selected' : ''); ?> >Super 60</option>
            <option value="<?= $curViewID ?>?style=Super70"  <?php echo ((isset($_GET['style']) && $_GET['style']=='Super70')?  'selected' : ''); ?> >Super 70</option>
            <option value="<?= $curViewID ?>?style=BTE"      <?php echo ((isset($_GET['style']) && $_GET['style']=='BTE')?      'selected' : ''); ?> >BTE</option>
            <option value="<?= $curViewID ?>?style=SuperBTE" <?php echo ((isset($_GET['style']) && $_GET['style']=='SuperBTE')? 'selected' : ''); ?> >Super BTE</option>
            <option value="<?= $curViewID ?>?style=Stock"    <?php echo ((isset($_GET['style']) && $_GET['style']=='Stock')?    'selected' : ''); ?> >Stock</option>
            <option value="<?= $curViewID ?>?style=Open"     <?php echo ((isset($_GET['style']) && $_GET['style']=='Open')?     'selected' : ''); ?> >Open Ear</option>
            <option value="<?= $curViewID ?>?style=Family"   <?php echo ((isset($_GET['style']) && $_GET['style']=='Family')?   'selected' : ''); ?> >Product Family</option>
            <option value="<?= $curViewID ?>?style=Misc"     <?php echo ((isset($_GET['style']) && $_GET['style']=='Misc')?     'selected' : ''); ?> >Guides &amp; Miscellaneous</option>
            <option value="<?= $curViewID ?>?style=Intro"    <?php echo ((isset($_GET['style']) && $_GET['style']=='Intro')?    'selected' : ''); ?> >Intro Documents</option>
          </select>
        </form>
    <?php 
    endif;
}

//-------------------------------------------------------------------------------------------------
// description:
// parameters :
// return     :
//-------------------------------------------------------------------------------------------------
function getLanguageHTMLString($Language)
{
    if ($Language == SPANISH){
        return "Espa&ntilde;ol";
    } elseif ($Language == ENGLISH) {
        return "English";
    }
}

//-------------------------------------------------------------------------------------------------
// description:
// parameters :
// return     :
//-------------------------------------------------------------------------------------------------
function getLanguageSuffix($Language)
{
    if ($Language == SPANISH) {
        return "es";
    } elseif ($Language == ENGLISH) {
        return "en";
    }
}
?>
