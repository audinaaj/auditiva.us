<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "content_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $intro_text
 * @property string $image
 * @property string $image_float
 * @property integer $show_title
 * @property integer $show_intro
 * @property integer $show_image
 * @property integer $ordering
 * @property integer $published
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property Content[] $contents
 */
class ContentCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['intro_text'], 'string'],
            [['show_title', 'show_intro', 'show_image', 'ordering', 'published', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'alias', 'image', 'image_float'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        //return [
        //    TimestampBehavior::className(),  // By default, TimestampBehavior will fill the created_at and updated_at attributes with the current timestamp
        //    BlameableBehavior::className(),  // By default, BlameableBehavior will fill the created_by and updated_by attributes with the current user ID
        //];
        
        date_default_timezone_set( 
          (!empty(Yii::$app->params['timezone']) ? Yii::$app->params['timezone'] : 'America/New_York') 
        );
     
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at', // OR 'create_time', to override default field name
                'updatedAtAttribute' => 'updated_at', // OR 'update_time', to override default field name
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',  // OR 'author_id', to override default field name
                'updatedByAttribute' => 'updated_by',  // OR 'updater_id', to override default field name
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'title'       => Yii::t('app', 'Title'),
            'alias'       => Yii::t('app', 'Alias'),
            'intro_text'  => Yii::t('app', 'Introductory Text'),
            'image'       => Yii::t('app', 'Image'),
            'image_float' => Yii::t('app', 'Image Float'),
            'show_title'  => Yii::t('app', 'Show Title'),
            'show_intro'  => Yii::t('app', 'Show Introduction'),
            'show_image'  => Yii::t('app', 'Show Image'),
            'ordering'    => Yii::t('app', 'Ordering'),
            'published'   => Yii::t('app', 'Published'),
            'created_by'  => Yii::t('app', 'Created by'),
            'created_at'  => Yii::t('app', 'Created at'),
            'updated_by'  => Yii::t('app', 'Updated by'),
            'updated_at'  => Yii::t('app', 'Updated at'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            return true;
        }
        return false;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::className(), ['category_id' => 'id']);
    }
    
    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
