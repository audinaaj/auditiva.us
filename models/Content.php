<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $title
 * @property integer $category_id
 * @property string $tags
 * @property string $slug
 * @property string $intro_text
 * @property string $full_text
 * @property string $intro_image
 * @property string $intro_image_float
 * @property string $main_image
 * @property string $main_image_float
 * @property integer $hits
 * @property integer $rating_sum
 * @property integer $rating_count
 * @property integer $show_title
 * @property integer $show_intro
 * @property integer $show_image
 * @property integer $show_hits
 * @property integer $show_rating
 * @property integer $content_type_id
 * @property integer $featured
 * @property integer $ordering
 * @property string $publish_up
 * @property string $publish_down
 * @property integer $status
 * @property integer $created_by
 * @property string $created_at
 * @property integer $updated_by
 * @property string $updated_at
 *
 * @property ContentCategory $category
 * @property ContentType $contentType
 */
class Content extends \yii\db\ActiveRecord
{
    // Model constants
    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['category_id', 'hits', 'rating_sum', 'rating_count', 'show_title', 'show_intro', 'show_image', 'show_hits', 'show_rating', 'content_type_id', 'featured', 'ordering', 'status', 'created_by', 'updated_by'], 'integer'],
            [['intro_text', 'full_text'], 'string'],
            [['publish_up', 'publish_down', 'created_at', 'updated_at'], 'safe'],
            [['title', 'tags', 'intro_image', 'intro_image_float', 'main_image', 'main_image_float'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        date_default_timezone_set('America/New_York');
        $formattedCurDateTime = date('Y-m-d H:i:s'); // same format as NOW()
        
        return [
            //TimestampBehavior::className(),  // By default, TimestampBehavior will fill the created_at and updated_at attributes with the current timestamp
            //BlameableBehavior::className(),  // By default, BlameableBehavior will fill the created_by and updated_by attributes with the current user ID
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at', // OR 'create_time', to override default field name
                'updatedAtAttribute' => 'updated_at', // OR 'update_time', to override default field name
                'value' => new \yii\db\Expression('NOW()'),
                //'value' => new \yii\db\Expression($formattedCurDateTime),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',  // OR 'author_id', to override default field name
                'updatedByAttribute' => 'updated_by',  // OR 'updater_id', to override default field name
            ],
            [
                'class' => SluggableCloneBehavior::className(),//SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'title'             => Yii::t('app', 'Title'),
            'category_id'       => Yii::t('app', 'Category ID'),
            'tags'              => Yii::t('app', 'Tags'),
            'intro_text'        => Yii::t('app', 'Introduction Text'),
            'full_text'         => Yii::t('app', 'Full Text'),
            'intro_image'       => Yii::t('app', 'Intro Image'),
            'intro_image_float' => Yii::t('app', 'Introduction Image Float'),
            'main_image'        => Yii::t('app', 'Main Image'),
            'main_image_float'  => Yii::t('app', 'Main Image Float'),
            'hits'              => Yii::t('app', 'Hits'),
            'rating_sum'        => Yii::t('app', 'Rating Sum'),
            'rating_count'      => Yii::t('app', 'Rating Count'),
            'show_title'        => Yii::t('app', 'Show Title'),
            'show_intro'        => Yii::t('app', 'Show Intro'),
            'show_image'        => Yii::t('app', 'Show Image'),
            'show_hits'         => Yii::t('app', 'Show Hits'),
            'show_rating'       => Yii::t('app', 'Show Rating'),
            'content_type_id'   => Yii::t('app', 'Content Type ID'),
            'featured'          => Yii::t('app', 'Featured'),
            'ordering'          => Yii::t('app', 'Ordering'),
            'publish_up'        => Yii::t('app', 'Publish Up'),
            'publish_down'      => Yii::t('app', 'Publish Down'),
            'status'            => Yii::t('app', 'Status'),
            'created_by'        => Yii::t('app', 'Created by'),
            'created_at'        => Yii::t('app', 'Created at'),
            'updated_by'        => Yii::t('app', 'Updated by'),
            'updated_at'        => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ContentCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentType()
    {
        return $this->hasOne(ContentType::className(), ['id' => 'content_type_id']);
    }
    
    public function getCategories()
    {
        return ContentCategory::find()->all();
    }
    
    public function getContentTypes()
    {
        return ContentType::find()->all();
    }
    
    public function getCreatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
        
        // Alternatively
        //if (($model = User::findOne($this->created_by)) !== null) {
        //    return $model;
        //} else {
        //    //throw new NotFoundHttpException('The requested page does not exist.');
        //    return new User();
        //}
    }
    
    public function getUpdatedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);

        // Alternatively
        /*
        if (($model = User::findOne($this->updated_by)) !== null) {
            var_dump($model);
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return new User();
        } */
    }

    public function getMotdStyle()
    {
        $alert_style = 'alert alert-danger';

        // make sure content type is motd
        if ($this->content_type_id != 8) {
            return $alert_style;
        }

        switch ($this->tags) {
            case 'danger':
            case 'warning':
            case 'success':
            case 'info':
                $alert_style = "alert alert-$this->tags";
                break;
        }

        return $alert_style;
    }

}

class SluggableCloneBehavior extends SluggableBehavior 
{
    protected function isNewSlugNeeded()
    {
        // check for clone based on title and ignore slug until title is changed.
        if (is_scalar($this->attribute) &&
            $this->attribute == 'title' &&
            strpos($this->owner->{$this->attribute}, '(Copy)') !== false)
        {
            $this->immutable = false;
            return false;
        }

        return parent::isNewSlugNeeded();
    }
}