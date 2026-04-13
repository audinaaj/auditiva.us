<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "distributor".
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $name_prefix
 * @property string $occupation
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $state_prov
 * @property string $postal_code
 * @property string $country
 * @property string $dist_country
 * @property string $latitude
 * @property string $longitude
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $services
 * @property string $hours
 * @property string $instructions
 * @property integer $status
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 */
class Distributor extends \yii\db\ActiveRecord
{
    // Constants
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distributor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hours', 'instructions'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            //[['created_by', 'created_at', 'updated_by', 'updated_at'], 'required'],
            [['company_name', 'address', 'city', 'country'], 'required'],
            [['created_at', 'updated_at', 'dist_country'], 'safe'],
            [['first_name', 'last_name', 'occupation', 'company_name', 'address', 'city', 'state_prov', 'postal_code', 'country', 
              'latitude', 'longitude', 'phone', 'email', 'website', 'services'], 'string', 'max' => 255],
            [['name_prefix', 'fax'], 'string', 'max' => 50]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //TimestampBehavior::class,  // By default, TimestampBehavior will fill the created_at and updated_at attributes with the current timestamp
            //BlameableBehavior::class,  // By default, BlameableBehavior will fill the created_by and updated_by attributes with the current user ID
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'name_prefix' => Yii::t('app', 'Name Prefix'),
            'occupation' => Yii::t('app', 'Occupation'),
            'company_name' => Yii::t('app', 'Company Name'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'state_prov' => Yii::t('app', 'State / Province'),
            'postal_code' => Yii::t('app', 'ZIP / Postal Code'),
            'country' => Yii::t('app', 'Country'),
            'dist_country' => Yii::t('app', 'Distribution Country'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'services' => Yii::t('app', 'Services'),
            'hours' => Yii::t('app', 'Hours'),
            'instructions' => Yii::t('app', 'Instructions'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->id;
                $this->created_at = new \yii\db\Expression('NOW()');
            } else {
                $this->updated_by = Yii::$app->user->id;
                $this->updated_at = new \yii\db\Expression('NOW()');
            }
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // on create make the distribution country the same as the physical country
            if ($insert) {
                if (empty($this->dist_country)) {
                    $this->dist_country = $this->country;
                }
            }
            return true;
        }
        return false;
    }

    public function getCreatedByUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
    
    public function getUpdatedByUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
