<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_type".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $published
 *
 * @property Content[] $contents
 */
class ContentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['published'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => Yii::t('app', 'ID'),
            'title'     => Yii::t('app', 'Title'),
            'alias'     => Yii::t('app', 'Alias'),
            'published' => Yii::t('app', 'Published'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::class, ['content_type_id' => 'id']);
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
