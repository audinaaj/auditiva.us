<?php
// Write() defaults
$defaultfont  = 'dejavusans'; // dejavusans supports UTF8, 'helvetica' does not
$height       = 0;
$isbgfilled   = false;
$isnewline    = true;
$stretch      = 0;
$isfirstline  = false;
$isfirstblock = false;
$heightmax    = 0;

// Label defaults
$unitsperpagewidth  = 216;  // mm for US Letter size (8.5 x 11 inches (216 mm x 279 mm)), Portrait orientation
$unitsperpageheight = 279;  // mm for US Letter size (8.5 x 11 inches (216 mm x 279 mm)), Portrait orientation

//###---- User Modifiable Variables ----###
//#
$leftmargin     = 5;   // mm
$topmargin      = 15;  // mm
$rightmargin    = 5;   // mm
$bottommargin   = 15;  // mm
$intercolmargin = 3;   // mm
$interrowmargin = 1;   // mm
$colsperpage    = 3;   // label columns
$rowsperpage    = 5;   // label rows

// Line style (array). Array with keys among the following:
// - width (float)  : Width of the line in user units.
// - cap (string)   : Type of cap to put on the line. Possible values are: butt, round, square. The difference between "square" and "butt" is that "square" projects a flat end past the end of the line.
// - join (string)  : Type of join. Possible values are: miter, round, bevel.
// - dash (mixed)   : Dash pattern. Is 0 (without dash) or string with series of length values, which are the lengths of the on and off dashes. For example: "2" represents 2 on, 2 off, 2 on, 2 off, ...; "2,1" is 2 on, 1 off, 2 on, 1 off, ...
// - phase (integer): Modifier on the dash pattern which is used to shift the point at which the pattern starts.
// - color (array)  : Draw color. Format: array(GREY) or array(R,G,B) or array(C,M,Y,K) or array(C,M,Y,K,SpotColorName).
$cellborder     = array('LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 2, 'color' => array(200, 200, 200))); // gray border
//$cellborder     = 1;   // 0: no border (default), 1: frame, L: left, T: top, R: right, B: bottom
$cellfill       = false;  // true: painted, false: transparent

$printbarcode   = true;
$printwatermark = true;

$leftmargin     = 1; // mm
$topmargin      = 1; // mm
$rightmargin    = 1; // mm
$bottommargin   = 1; // mm
$intercolmargin = 1; // mm
$interrowmargin = 1; // mm
$colsperpage    = 1; // label columns
$rowsperpage    = 1; // label rows

//#
//################################

$labelsperpage  = ($colsperpage * $rowsperpage);
$cellwidth      = ($unitsperpagewidth - $leftmargin - ($intercolmargin * ($colsperpage-1)) - $rightmargin) / $colsperpage; 
$cellheight     = ($unitsperpageheight - $topmargin - ($interrowmargin * ($rowsperpage-1)) - $bottommargin) / $rowsperpage;
//$watermarkmaxchars = ($colsperpage == 3 ? 500 : 800);
$watermarkmaxchars = ($colsperpage == 3 ? 500 : 440);

$headertitle    = 'Cable Reference';
$headersubtitle = 'Comprehensive reference for cables, connectors, and programming box to use while fitting hearing aids.';


// create new PDF document
$pdf = new TCPDF('P' /* Page orientation (P=portrait, L=landscape) */, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//$pdf->SetHeaderData('', 0, $headertitle, $headersubtitle);
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Nano-coating Log Report', 'Acme | www.acme.com', array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
// $pdf->setPrintHeader(false);  // do not print footer
// $pdf->setPrintFooter(false);  // do not print footer

// set default monospaced font
//$pdf->SetDefaultMonospacedFont('courier');

// set margins
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 25);

// set image scale factor

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
//$defaultfont = 'DejaVuSansMono'; //PDF_FONT_MONOSPACED; //'dejavusans';
$defaultfont = 'dejavusans'; 
//$pdf->SetFont($defaultfont, 'B', 18);
//$pdf->SetFont($defaultfont, '', 8, '', true);

// ---------------------------------------------------------
// Add Page
// ---------------------------------------------------------
set_time_limit(0);  // set execution time limit to None

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// ---------------------------------------------------------
// Doc Content
// ---------------------------------------------------------
$pdf->AddPage(); 
$Xoffset = $leftmargin + 13; 
$Yoffset = $topmargin  + 10;
$pdf->SetFont($defaultfont, '', 16);
$pdf->SetXY($Xoffset, $Yoffset); 
$pdf->Write($height, $headertitle,  '', 0, 'L', 0 /*$isnewline*/, $stretch, $isfirstline, $isfirstblock, $heightmax);
$pdf->SetFont($defaultfont, '', 10);
$pdf->SetXY($Xoffset, $Yoffset+6); 
$pdf->Write($height, Yii::$app->params['companyName'],  '', 0, 'L', 0 /*$isnewline*/, $stretch, $isfirstline, $isfirstblock, $heightmax);
//$pdf->SetXY($Xoffset, $Yoffset+10);
//$pdf->Write($height, $headersubtitle,  '', 0, 'L', 0 /*$isnewline*/, $stretch, $isfirstline, $isfirstblock, $heightmax);
$pdf->SetXY($Xoffset, $Yoffset+11); 
$pdf->SetFont($defaultfont, '', 6);
$pdf->Write($height, "Report generated " . date("M d, Y, h:m:i a"),  '', 0, 'L', 1 /*$isnewline*/, $stretch, $isfirstline, $isfirstblock, $heightmax);

$pdf->SetDrawColor(0, 0, 0);
$pdf->Line($Xoffset, $Yoffset+15, $Xoffset+180, $Yoffset+15);  // horizontal line

$pdf->SetFont($defaultfont, '', 16);
$pdf->SetXY($Xoffset, $Yoffset+20);
//$pdf->Write($height, "Cable Matrix",  '', 0, 'L', 1 /*$isnewline*/, $stretch, $isfirstline, $isfirstblock, $heightmax);
$pdf->SetFont($defaultfont, '', 8);
$tbl = getCablesMatrixTable($data);
$pdf->writeHTML($tbl, true /* newline */, false /* fill */, false /* reset height */, false /* add padding */, '' /* alignment */);
$pdf->AddPage(); 
$tbl = getCablesTable($dataCables);
$pdf->writeHTML($tbl, true /* newline */, false /* fill */, false /* reset height */, false /* add padding */, '' /* alignment */);
$pdf->AddPage(); 
$tbl = getConnectorsTable($dataConnectors);
$pdf->writeHTML($tbl, true /* newline */, false /* fill */, false /* reset height */, false /* add padding */, '' /* alignment */);
$pdf->AddPage(); 
$tbl = getProgrammingBoxTable($dataProgBox);
$pdf->writeHTML($tbl, true /* newline */, false /* fill */, false /* reset height */, false /* add padding */, '' /* alignment */);
$pdf->AddPage(); 
$tbl = getHousingTable($dataHousing);
$pdf->writeHTML($tbl, true /* newline */, false /* fill */, false /* reset height */, false /* add padding */, '' /* alignment */);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//$pdf->Output('Order-'.str_pad($model->id, 6, "0", STR_PAD_LEFT).'-labels.pdf', 'I');
$pdf->Output(Yii::$app->params['appNameShort']."-".Yii::$app->controller->action->id.".pdf", 'I');


//============================================================+
// END OF FILE
//============================================================+
// Close Yii2
\Yii::$app->end();
?>

<?php
//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getCablesMatrixTable($arrData)
{
    // Cables
    arsort($arrData);
    $aTable  = '<h1>Cable Matrix</h1>';
    $aTable .= '<table cellspacing="0" cellpadding="5" border="1">';
    $aTable .= '<tr>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Product</th>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Housing</th>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Cable</th>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Connector</th>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Programmer</th>';
    $aTable .= '  <th style="background-color: lightgray; font-weight: bold;">Notes</th>';
    $aTable .= '</tr>';
    foreach($arrData as $row) {
        $label = getCableLabel($row['cable']);
        $aTable .= "<tr>";
        $aTable .= "  <td>{$row['product']}</td>";
        $aTable .= "  <td>{$row['housing']}</td>";
        $aTable .= "  <td>{$label}</td>";
        $aTable .= "  <td>{$row['connector']}</td>";
        $aTable .= "  <td>{$row['programmer']}</td>";
        $aTable .= "  <td>{$row['notes']}</td>";
        $aTable .= "</tr>";
    }
    $aTable .= "</table>";
    return $aTable;
}

//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getCablesTable($dataCables)
{
    $docRootURL = Yii::$app->urlManager->createUrl('');
    
    $content  = '<h1>Cables</h1>';
    $content .= '<table cellspacing="0" cellpadding="5" border="1">';
    $content .= '<tr>';
    $content .= '  <th style="width: 150px; background-color: lightgray; font-weight: bold;">Name</th>';
    $content .= '  <th style="width: 150px; background-color: lightgray; font-weight: bold;">Cable</th>';
    $content .= '  <th style="width: 100px; background-color: lightgray; font-weight: bold;">Compatibility</th>';
    $content .= '  <th style="width: 250px; background-color: lightgray; font-weight: bold;">Notes</th>';
    $content .= '</tr>';
    
    foreach($dataCables as $row) {
        $content .= "<tr>";
        $content .= "  <td><h3>".getCableLabel($row['name'])."</h3></td>";
        $content .= "  <td><img src=\"".$docRootURL."media/reference/{$row['image']}\" class='img-responsive' align='center' width='150'></td>";
        $content .= "  <td>{$row['compatible']}</td>";
        $content .= "  <td>{$row['notes']}</td>";
        $content .= "</tr>";
    }
    $content .= '</table>';
    
    return $content;
}

//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getConnectorsTable($dataConnectors)
{
    $docRootURL = Yii::$app->urlManager->createUrl('');
    
    $content  = '<h1>Connectors</h1>';
    $content .= '<table cellspacing="0" cellpadding="5" border="1">';
    $content .= '<tr>';
    $content .= '  <th style="width: 150px; background-color: lightgray; font-weight: bold;">Name</th>';
    $content .= '  <th style="width: 150px; background-color: lightgray; font-weight: bold;">Connector</th>';
    $content .= '  <th style="width: 350px; background-color: lightgray; font-weight: bold;">Notes</th>';
    $content .= '</tr>';
    
    foreach($dataConnectors as $row) {
        $content .= "<tr>";
        $content .= "  <td>{$row['name']}</td>";
        $content .= "  <td><img src=\"".$docRootURL."media/reference/{$row['image']}\" class='img-responsive' align='center' width='150'></td>";
        $content .= "  <td>{$row['notes']}</td>";
        $content .= "</tr>";
    }
    $content .= '</table>';
    
    return $content;
}

//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getProgrammingBoxTable($dataProgBox)
{
    $docRootURL = Yii::$app->urlManager->createUrl('');
    
    $content  = '<h3>Programmers</h3>';
    $content .= '<table cellspacing="0" cellpadding="5" border="1">';
    $content .= '<tr>';
    $content .= '  <th style="width: 100px; background-color: lightgray; font-weight: bold;">Name</th>';
    $content .= '  <th style="width: 150px; background-color: lightgray; font-weight: bold;">Programmers</th>';
    $content .= '  <th style="width: 400px; background-color: lightgray; font-weight: bold;">Data Cable</th>';
    $content .= '</tr>';
    
    foreach($dataProgBox as $row) {
        $content .= "<tr>";
        $content .= "  <td>{$row['name']}</td>";
        $content .= '  <td><img src="' . $docRootURL . 'media/reference/'.$row['prog-box-image']   . '" class="img-responsive" align="center" width="140"></td>';
        $content .= '  <td><img src="' . $docRootURL . 'media/reference/'.$row['data-cable-image'] . '" class="img-responsive" align="center" width="140">'.$row['notes'].'</td>';
        $content .= '</tr>';
    }
    $content .= '</table>';
    return $content;
}

//---------------------------------------------------------------------------------------------
// description: 
// parameters :
// return     :
//---------------------------------------------------------------------------------------------
function getHousingTable($dataHousings)
{
    $docRootURL = Yii::$app->urlManager->createUrl('');
    
    $content  = '<h3>Housings</h3>';
    $content .= '<table cellspacing="0" cellpadding="5" border="1">';
    $content .= '<tr>';
    $content .= '  <th style="width: 75px; background-color: lightgray; font-weight: bold;">Name</th>';
    $content .= '  <th style="width: 75px; background-color: lightgray; font-weight: bold;">Type</th>';
    $content .= '  <th style="width: 120px; background-color: lightgray; font-weight: bold;">Housing</th>';
    $content .= '  <th style="width: 120px; background-color: lightgray; font-weight: bold;">Connection</th>';
    $content .= '  <th style="width: 60px; background-color: lightgray; font-weight: bold;">Cable</th>';
    $content .= '  <th style="width: 100px; background-color: lightgray; font-weight: bold;">Connector</th>';
    $content .= '  <th style="width: 100px; background-color: lightgray; font-weight: bold;">Notes</th>';
    $content .= '</tr>';
    
    foreach($dataHousings as $row) {
        $content .= "<tr>";
        $content .= "  <td>{$row['name']}</td>";
        $content .= "  <td>{$row['type']}</td>";
        $content .= '  <td><img src="' . $docRootURL . 'media/reference/'.$row['image']            . '" class="img-responsive" align="center" width="120"></td>';
        $content .= '  <td><img src="' . $docRootURL . 'media/reference/'.$row['connection-image'] . '" class="img-responsive" align="center" width="120"></td>';
        $content .= "  <td>{$row['cable']}</td>";
        $content .= "  <td>{$row['connector']}</td>";
        $content .= "  <td>{$row['notes']}</td>";
        $content .= '</tr>';
    }
    $content .= '</table>';
    return $content;
}

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