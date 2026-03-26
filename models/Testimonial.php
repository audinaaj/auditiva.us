<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%testimonial}}".
 *
 * @property int $id
 * @property string $comment
 * @property string $author
 * @property string $location
 * @property string $tags
 * @property int $status
 */
class Testimonial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%testimonial}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['comment', 'author', 'location', 'tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'comment'  => Yii::t('app', 'Comment'),
            'author'   => Yii::t('app', 'Author'),
            'location' => Yii::t('app', 'Location'),
            'tags'     => Yii::t('app', 'Tags'),
            'status'   => Yii::t('app', 'Status'),
        ];
    }
}
