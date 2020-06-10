<?php

namespace app\models;

use Yii;
use yii\base\Model;         // parent for model classes not associated with database tables
//use yii\db\ActiveRecord;  // parent for model classes that do correspond to database tables

/**
 * This is the model class for table "StringUtils".
 */
class StringUtils extends Model
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Strip specified substring from end of provided string.
    //              Usage: StringUtils::rtrim_string($str, $strToRemove);  
    // parameters : $str, $strToRemove (default: spaces)
    // return     : $str (edited string)
    //---------------------------------------------------------------------------------------------
    public static function rtrim_string($str, $strToRemove="")
    {
        if (empty($strToRemove)) {
            $str = rtrim($str);
        } else {
            //return preg_replace("/{$strToRemove}$/s", "", $str);  // same solution, but using regex (one liner)
            
            $len = strlen($strToRemove);
            if (strcmp(substr($str, -$len, $len), $strToRemove) === 0) {
                $str = substr($str, 0, -$len);
            }
        }
        return $str;
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Strip specified substring from start of provided string.
    //              Usage: StringUtils::rtrim_string($str, $strToRemove);  
    // parameters : $str, $strToRemove
    // return     : $str (edited string)
    //---------------------------------------------------------------------------------------------
    public static function ltrim_string($str, $strToRemove="")
    {
        if (empty($strToRemove)) {
            $str = ltrim($str);
        } else {
            //return preg_replace("/^{$strToRemove}/s", "", $str);  // same solution, but using regex (one liner)
            
            $len = strlen($strToRemove);
            if (strcmp(substr($str, 0, $len), $strToRemove) === 0) {
                $str = substr($str, $len);
            }
        }
        return $str;
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Strip any spaces.
    //              Usage: StringUtils::stripSpaces($str);  
    // parameters : $str
    // return     : $str (formatted string)
    //---------------------------------------------------------------------------------------------
    public static function stripSpaces($str)
    {
        return (str_replace(' ', '', trim($str)));
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Strip extra commas
    //              Usage: StringUtils::stripExtraChars($str);  
    // parameters : $str
    // return     : $str (formatted string)
    //---------------------------------------------------------------------------------------------
    public static function stripExtraChars($str)
    {
        //$str = str_replace([", , , ,", ", , ,", ", ,", ",,"], ",", $str);   // Strip extra commas (2 - 4 commas replaced by 1)
        $str = preg_replace('/,+/', ',', $str);                             // Strip extra commas (any number of commas replaced by 1)
        $str = preg_replace('/,$/s', '', $str);                             // Strip ending commas
        $str = trim($str,",");                                              // Strip starting commas
        //$str = preg_replace('/^[,\s]+|[\s,]+$/', '', $str);                 // Strip leading/trailing commas with whitespace around
        $str = trim($str);                                                  // Strip spaces at the extremes    
        
        return $str;
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Strip newline and return characters from string.
    //              Usage: StringUtils::stripNewLineReturn($str); 
    // parameters : $str
    // return     : $str (formatted string)
    //---------------------------------------------------------------------------------------------
    public static function stripNewLineReturn($str)
    {
        //$str = Sanitize::clean($str, array('encode' => false));   // add to top: App::uses('Sanitize', 'Utility');
        return str_replace(array("\n","\r\n","\r"), "", $str);
    }

    //---------------------------------------------------------------------------------------------
    // description: Generate correct first letter uppercase names.
    //              Usage: StringUtils::nameize($aName); 
    // parameters : $str, $delimiters
    // return     : $str (formatted string)
    //---------------------------------------------------------------------------------------------
    public static function nameize($str, $delimiters = ["'", "-", " ", "Mc", "/", ":", ".", "(", ")", "*", ","])
    {   
        // Check if string is all lowercase/uppercase, which would then need processing.
        //$requiresprocessing = false;
        //$testdata = explode(" ", $str);
        //foreach($testdata as $word) {
        //    if (ctype_lower($word) || ctype_upper($word)) {
        //        $requiresprocessing = true;
        //        break;
        //    }
        //}
        $requiresprocessing = true;
        
        // Remove double spaces
        $str = trim(str_replace("  ", " ", $str));
        
        // Change to uppercase first letter of each name, including special cases.
        // Eg: O'connell to O'Connell, Perez-morales to Perez-Morales, and Mcdonald to McDonald
        // Params:
        //  $str          Contains the complete raw name string.
        //  $delimiters   An array containing the characters used as separators for capitalization. 
        //                If you don't pass anything, there are four in there as default.
        if ($requiresprocessing) {
            //$str = ucfirst($str);
            //$str = ucwords(strtolower($str));  // strtolower() not safe with UTF-8
            $str = ucwords(mb_strtolower($str, 'UTF-8'));
            
            foreach ($delimiters as $delimiter) {
                $pos = strpos($str, $delimiter);
                if ($pos !== false) {
                    // Found one of the special characters in the array, 
                    // so lets split it up into chunks and capitalize each one.
                    $mend = '';
                    $a_split = explode($delimiter, $str);
                    foreach ($a_split as $chunk) {
                        // Adjust capitalization for each portion of the string which was separated at a delimiter
                        //if (($chunk == "ii") || ($chunk == "iii") || ($chunk == "iii") || ($chunk == "iv") || ($chunk == "vi") || ($chunk == "vii") || ($chunk == "ix")) {
                        //if (preg_match("/\b(?:XL|L|L?(?:IX|X{1,3}|X{0,3}(?:IX|IV|V|V?I{1,3})))/b/", mb_strtoupper($chunk, 'UTF-8'))) {
                        if (preg_match("/^(M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})|[IDCXMLV])$/", mb_strtoupper($chunk, 'UTF-8'))) {
                            // Capitalize basic Roman numerals
                            $mend .= mb_strtoupper($chunk, 'UTF-8') . $delimiter;  
                        } else if (in_array(mb_strtolower($chunk, 'UTF-8'), ["del", "de", "du", "von"])) {
                            // Lowercase some prepositions
                            $mend .= mb_strtolower($chunk, 'UTF-8') . $delimiter;  
                        } else {
                            // Capitalize each portion of the string
                            $mend .= ucfirst($chunk) . $delimiter;
                        }
                    }
                    $str = substr($mend, 0, -strlen($delimiter));  // strip end delimiter
                }
            }
        } 
        
        return $str;
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Generate first letter uppercase names.
    //              Usage: StringUtils::ucname($aName); 
    // parameters : $str, $delimiters
    // return     : $str (formatted string)
    //---------------------------------------------------------------------------------------------
    public static function ucname($str) 
    {
        $str = ucwords(mb_strtolower($str, 'UTF-8'));

        foreach (['-', '\''] as $delimiter) {
          if (strpos($str, $delimiter) !== false) {
            $str = implode($delimiter, array_map('ucfirst', explode($delimiter, $str)));
          }
        }
        return $str;
    }

    //---------------------------------------------------------------------------------------------
    // description: Filter to strip out non-alphanumeric characters from string.
    //              Usage: StringUtils::filterAlphaNumCharsOnly($str); 
    // parameters : $str
    // return     : $str (alphanumeric string)
    //---------------------------------------------------------------------------------------------
    public static function filterAlphaNumCharsOnly($str)
    {
        return preg_replace("/[^a-zA-Z0-9]+/", "", $str);
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Filter to strip out non-alpha characters from string.
    //              Usage: StringUtils::filterAlphaNumCharsOnly($str); 
    // parameters : $str
    // return     : $str (alpha string)
    //---------------------------------------------------------------------------------------------
    public static function filterAlphaCharsOnly($str)
    {
        return preg_replace("/[^A-Za-z]+/", "", $str);
    }
    
    //---------------------------------------------------------------------------------------------
    // description: Get array data from XML string. 
    // parameters : $strXml
    // return     : $arrData
    //---------------------------------------------------------------------------------------------
    public static function getXmlDataAsArray($strXml)
    {
        $xml     = simplexml_load_string($strXml);
        $arrData = json_decode(json_encode((array)$xml), true /* assoc */);
        $arrData = array($xml->getName() => $arrData);
        
        return $arrData;
    }
}
