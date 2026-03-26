<?php

namespace app\models;

use Yii;
use yii\base\Model;         // parent for model classes not associated with database tables
//use yii\db\ActiveRecord;  // parent for model classes that do correspond to database tables

/**
 * This is the model class for table "DataUtils".
 */
class UtilsData extends Model
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export array data to CSV formatted file.
    /// Usage:
    ///     $data = [
    ///         ["id", "description"],
    ///         [1, "Volvo"],
    ///         [2, "BMW"],
    ///         [3, "Toyota"],
    ///     ];
    ///     DataUtils::exportToFileCsv($data, 'download.csv');
    /// Params: 
    ///    $data.  Two-dimensional array of data to export.  First row is assumed to include column headers.
    ///    $file_name (default 'file.csv') 
    ///    $include_separator (default false). Required to set default separator to TAB, 
    ///                                        to generate Excel-compatible tab-separated CSV file.
    /// Source: See more at: https://arjunphp.com/create-download-csv-files-php/#sthash.f6JCTy4J.dpuf
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportToFileCsv($data, $file_name = 'file.csv', $include_separator=false)
    {
        // Output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename={$file_name}");
        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Start the ouput
        $output = fopen("php://output", "w");
        if ($include_separator) {
            fwrite($output, "sep=\t\n"); // set default separator to TAB, so Excel can import CSV as tab-separated
        }

        // Then loop through the rows
        foreach ($data as $row) {
            # Add the rows to the body
            //fputcsv($output, $row); // here you can change delimiter/enclosure
            fputcsv($output, $row, "\t"); // here you can change delimiter/enclosure
        }
        // Close the stream off
        fclose($output);
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export array data to Excel formatted file.
    /// Usage:
    ///     $data = [
    ///         ["id", "description"],
    ///         [1, "Volvo"],
    ///         [2, "BMW"],
    ///         [3, "Toyota"],
    ///     ];
    ///     DataUtils::exportToFileExcel($data, 'download.xls');
    /// Params: 
    ///    $data      Two-dimensional array of data to export.  First row is assumed to include column headers.
    ///    $file_name (default 'file.xls') 
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportToFileExcel($data, $file_name = 'file.xls')
    {
        date_default_timezone_set( (!empty(Yii::$app->params['timezone']) ? Yii::$app->params['timezone'] : 'America/New_York') );

        $docExcel = new \PHPExcel();  // requires: 'PHPExcel' => array($vendorDir . '/phpoffice/phpexcel/Classes'), (In @app/vendor/composer/autoload_namespaces.php)
        $docExcel->setActiveSheetIndex(0);
        $docExcel->getActiveSheet()->fromArray($data, null, 'A1');
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');

        // Output data
        $writer = \PHPExcel_IOFactory::createWriter($docExcel, 'Excel5');
        $writer->save('php://output');
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export array data to HTML formatted file.
    /// Usage:
    ///     $fields = ["id", "description", "price"];  // optional
    ///     $data = [
    ///         ["id", "description"],  // optional
    ///         [1, "Volvo"],
    ///         [2, "BMW"],
    ///         [3, "Toyota"],
    ///     ];
    ///     DataUtils::exportToFileHtml($data, $fields, 'download.html');
    /// Params: 
    ///    $data      Two-dimensional array of data to export.  First row is assumed to include column headers.
    ///    $fields    Optional list of field names to use as column headers. 
    ///    $file_name (default 'file.html') 
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportToFileHtml($data, $fields, $file_name = 'file.html')
    {
        // output headers so that the file is downloaded rather than displayed
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$file_name);

        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Start the ouput
        $output = fopen("php://output", "w");
        
        fwrite($output, '<table border="0" width="100%">'."\n");
        
        if (!empty($fields) && count($fields) > 0) {
            // Add the fields row to the body
            fwrite($output, "<thead>\n");
            fwrite($output, "<tr>\n  <th>");
            fwrite($output, implode("</th>\n  <th>", $fields));
            fwrite($output, "</th>\n</tr>\n");
            fwrite($output, "</thead>\n");
        }
        
        // Loop through the rows of data
        foreach ($data as $row) {
            // encode for HTML entities
            foreach ($row as $key => $cell) {
                $row[$key] = \yii\helpers\Html::encode($cell);
            }
            
            // Add the data rows to the body
            fwrite($output, "<tr>\n  <td>");
            fwrite($output, implode("</td>\n  <td>", $row));
            fwrite($output, "</td>\n</tr>\n");
        }
        
        fwrite($output, '</table>');
        
        # Close the stream off
        fclose($output);
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export array data to HTML formatted file.
    /// Usage:
    ///     $fields     = ["id", "description", "price"];
    ///     $models     = Price::find()->all();
    ///     $memofields = ['details', 'notes'];
    ///     DataUtils::exportModelsToFileCsv($models, $fields, 'download.html', true /* include separator */, $memofields);
    /// Params: 
    ///    $models    \yii\db\Query data
    ///    $fields    Optional array of field names to use as filter. Field names extracted from model if empty. Eg: ['id', 'item_code', 'description']
    ///    $file_name (default 'file.csv')
    ///    $include_separator (default false). Required to set default separator to TAB, 
    ///                                        to generate Excel-compatible tab-separated CSV file.
    ///    $memo_fields_to_escape (default ['notes'])  An array of memo field names whose content needs to be escaped.
    ///    $encode_fields (default false)  Encode field to avoid artifacts.
    ///    $return_data_as_string (default false)  Content is returned to standard output as default, but it can be returned as string data.
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportModelsToFileCsv($models, $fields, $file_name = 'file.csv', 
      $include_separator=false, $memo_fields_to_escape=['notes'], $encode_fields=false, $return_data_as_string=false)
    {
        if ($return_data_as_string) {
            // Start the ouput to a memory file
            $output = fopen("php://temp", "w");
        } else {
            // Output headers so that the file is downloaded rather than displayed
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename={$file_name}");
            // Disable caching - HTTP 1.1
            header("Cache-Control: no-cache, no-store, must-revalidate");
            // Disable caching - HTTP 1.0
            header("Pragma: no-cache");
            // Disable caching - Proxies
            header("Expires: 0");

            // Start the ouput to standard output
            $output = fopen("php://output", "w");
        }
        if ($include_separator) {
            fwrite($output, "sep=\t\n"); // set default separator to TAB, so Excel can import CSV as tab-separated
        }
        
        $filterByFields = (!empty($fields) && count($fields) > 0);  // When fields are provided, filter by field, else use all fields
        
        if (!$filterByFields) {
            // Extract fields names
            foreach ($models as $model) {
                // encode for HTML entities
                foreach ($model as $attrib => $val) {
                    $fields[] = $attrib;
                }
                break; // Exit loop after first model read.  We have all the field names now.
            }
        }
        fputcsv($output, $fields, "\t");

        // Loop through the rows of data
        foreach ($models as $model) {
            // encode for HTML entities
            $row = [];
            foreach ($model as $attrib => $val) {
                if (($filterByFields && in_array($attrib, $fields)) || !$filterByFields) {
                    if ($encode_fields) {
                        $row[$attrib] = \yii\helpers\Html::encode($val);
                    } else {
                        $row[$attrib] = $val;
                    }

                    if (in_array($attrib, $memo_fields_to_escape)) {
                        $row[$attrib] = str_replace("\r\n", "|", $row[$attrib]);
                    }
                } 
            }
            
            // Add the data rows to the body
            if (!empty($row)) {
                //fputcsv($output, $row); // here you can change delimiter/enclosure
                fputcsv($output, $row, "\t"); // here you can change delimiter/enclosure
            }
        }
        
        if ($return_data_as_string) {
            // Rewind the "file" so we can read what we just wrote...
            rewind($output);
            // Read the entire file into a variable...
            //$data = fread($output, 1048576);
            while ( ($buf = fread( $output, 8192 )) != '' ) {
                $data .= $buf;  // Here, $buf is guaranted to contain data
            }
            
            // Close the stream off
            fclose($output);
        
            return $data;
        } else {
            // Close the stream off
            fclose($output);
        }
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export \yii\db\Query data to Excel formatted file.
    /// Usage:
    ///     $models = Price::find()->all();
    ///     $fields = ["id", "description", "price"];
    ///     DataUtils::exportModelsToFileExcel($models, $fields, 'download.xls');
    /// Params: 
    ///    $models.  \yii\db\Query data
    ///    $fields    Optional array of field names to use as filter. Field names extracted from model if empty. Eg: ['id', 'item_code', 'description']
    ///    $file_name (default 'file.xls') 
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportModelsToFileExcel($models, $fields, $file_name = 'file.xls')
    {
        $headers = [];
        foreach($fields as $field) {
            $headers[$field] = $field;
        }
        
        \moonland\phpexcel\Excel::export([
            'fileName' => $file_name,
            'models'   => $models, 
            'columns'  => $fields, 
            'headers'  => $headers, 
        ]);
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Export array data to HTML formatted file.
    /// Usage:
    ///     $models = Price::find()->all();
    ///     $fields = ["id", "description", "price"];
    ///     DataUtils::exportToFileHtml($models, $fields, 'download.html');
    /// Params: 
    ///    $models    \yii\db\Query data
    ///    $fields    Optional array of field names to use as filter. Field names extracted from model if empty. Eg: ['id', 'item_code', 'description']
    ///    $file_name (default 'file.html') 
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function exportModelsToFileHtml($models, $fields, $file_name = 'file.html', $encode_fields = false)
    {
        // output headers so that the file is downloaded rather than displayed
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$file_name);

        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Start the ouput
        $output = fopen("php://output", "w");
        
        fwrite($output, '<table border="0" width="100%">'."\n");
        
        $filterByFields = (!empty($fields) && count($fields) > 0);  // When fields are provided, filter by field, else use all fields
        
        if (!$filterByFields) {
            // Extract fields names
            foreach ($models as $model) {
                // encode for HTML entities
                foreach ($model as $attrib => $val) {
                    $fields[] = $attrib;
                }
                break; // Exit loop after first model read.  We have all the field names now.
            }
        }

        // Add the fields row to the body
        fwrite($output, "<thead>\n");
        fwrite($output, "<tr>\n  <th>");
        fwrite($output, implode("</th>\n  <th>", $fields));
        fwrite($output, "</th>\n</tr>\n");
        fwrite($output, "</thead>\n");
         
        
        // Loop through the rows of data
        foreach ($models as $model) {
            // encode for HTML entities
            //$row = [];
            foreach ($model as $attrib => $val) {
                if (($filterByFields && in_array($attrib, $fields)) || !$filterByFields) {
                    if($encode_fields) {
                        $row[$attrib] = \yii\helpers\Html::encode($val);
                    } else {
                        $row[$attrib] = $val;
                    }
                } 
            }
            
            // Add the data rows to the body
            fwrite($output, "<tr>\n  <td>");
            if (!empty($row)){
                fwrite($output, implode("</td>\n  <td>", $row));
            }
            fwrite($output, "</td>\n</tr>\n");
        }
        
        fwrite($output, '</table>');
        
        // Close the stream off
        fclose($output);
    }
    
    ///----------------------------------------------------------------------------------------
    /// <summary>
    /// Description: Send email message.
    /// Usage:
    ///     DataUtils::sendMessage($srcMail, $srcName, $dstEmail, $subject, $textBody);
    /// Params: 
    ///    $srcMail   Sender's email address.
    ///    $srcName   Sender's name.
    ///    $dstEmail  Destination email address. 
    ///    $textBody  Email content.
    /// </summary>
    ///----------------------------------------------------------------------------------------
    public static function sendMessage($srcMail, $srcName, $dstEmail, $subject, $textBody)
    {
        $success = Yii::$app->mailer->compose()
                ->setFrom([$srcMail => $srcName])
                ->setTo($dstEmail)
                ->setBcc([Yii::$app->params['debugEmail'] => 'Debug Email'])
                ->setSubject($subject)
                ->setTextBody($textBody)
                ->send();
              
        return $success;
    }
}
