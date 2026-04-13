<?php

namespace app\models;

use Yii;
use yii\base\Model;         // parent for model classes not associated with database tables
//use yii\db\ActiveRecord;  // parent for model classes that do correspond to database tables

/**
 * This is the model class for table "DataUtils".
 */
class UtilsFitpro extends Model
{
    const FITPRO_4 = '4';
    const FITPRO_5 = '5';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * Returns an 8 digit code to unlock fitPRO for a day.
     * 
     * Example usage:
     *   echo "<tr><td>" . $calcDate->format("Y-m-d") . "</td><td>" . CalcTempUnlockCode($calcDate, 5). "</td></tr>";
     */
    public static function CalcTempUnlockCode($date, $version = self::FITPRO_5)
    {
        $day_of_year = $date->format("z") + 1;
        $year = $date->format("Y");
        $temp_seed = md5($day_of_year . $year);
        $full_code = md5("TemporaryUnlock".$temp_seed);
        return strtoupper(substr(($version == 4) ? $temp_seed : $full_code, 0, 8));
    }

    public static function GetPasswordTable($number_of_days, $version = self::FITPRO_5) {
        $timezone = new \DateTimeZone('America/New_York');
    
        echo '<table class="table table-striped table-hover" width="100%">';
        echo '<tbody>';
    
        $today = new \DateTimeImmutable("now", $timezone);
        for($i = 0; $i < $number_of_days; $i++) {
          $calcDate = $today->add(new \DateInterval('P'.$i.'D'));
    
          $date = $calcDate->format("Y-m-d");
          $code = self::CalcTempUnlockCode($calcDate, $version);

          echo '<tr>';
          echo "<td>$date</td>";
          echo "<td>$code <i class=\"fa fa-copy btn btn-default btn-clip pull-right\" data-clipboard-text=\"$code\"></i>";
          echo '</td>';
          echo '</tr>';
        }
    
        echo '</tbody>';
        echo '<thead>';
        echo '<tr><th>Date</th><th>Password</th></tr>';
        echo '</thead>';
        echo '</table>';
    }
}