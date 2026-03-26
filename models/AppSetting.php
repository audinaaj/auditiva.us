<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_setting".
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $default
 * @property string $status
 * @property string $type
 * @property string $unit
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 */
class AppSetting extends \yii\db\ActiveRecord
{
    // Constants
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['key', 'value', 'default', 'status', 'type', 'unit', 'role'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'key'        => Yii::t('app', 'Key'),
            'value'      => Yii::t('app', 'Value'),
            'default'    => Yii::t('app', 'Default'),
            'status'     => Yii::t('app', 'Status'),
            'type'       => Yii::t('app', 'Type'),
            'unit'       => Yii::t('app', 'Unit'),
            'role'       => Yii::t('app', 'Role'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
    
    public static function getDataTypeLabel($type) 
    {
        switch($type) {
            case 0:   $lbl = 'String'; break;
            case 1:   $lbl = 'Integer'; break;
            case 2:   $lbl = 'Boolean'; break;
            default:  $lbl = 'String'; break;
        }
        return ($lbl);
    }

    public static function getUnitLabel($unit) 
    {
        switch($unit) {
            case 0:   $lbl = 'None'; break;
            case 1:   $lbl = 'mm'; break;
            case 2:   $lbl = 'inches'; break;
            case 3:   $lbl = 'pixels'; break;
            case 4:   $lbl = 'count'; break;
            default:  $lbl = 'None'; break;
        }
        return ($lbl);
    }
}
