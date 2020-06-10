<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Content;
use app\models\ContentCategory;
use app\models\ContentType;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * ContentSearch represents the model behind the search form about `app\models\Content`.
 */
class ContentSearch extends Content
{
    // Add the public attributes that will be used to store the custom data to be searched
    // NOTE: Only required for fields not in current table, 
    // Eg: fields in related table such as 'content.category' using alias 'category'
    public $category;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'hits', 'rating_sum', 'rating_count', 'show_title', 'show_intro', 'show_image', 'show_hits', 'show_rating', 'content_type_id', 'ordering', 'status', 'created_by', 'updated_by'], 'integer'],
            [['title', 'category_id', 'category', 'tags', 'intro_text', 'full_text', 'intro_image', 'intro_image_float', 'main_image', 'main_image_float', 'publish_up', 'publish_down', 'created_at', 'updated_at', 'featured'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),  // By default, TimestampBehavior will fill the created_at and updated_at attributes with the current timestamp
            BlameableBehavior::className(),  // By default, BlameableBehavior will fill the created_by and updated_by attributes with the current user ID
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //$query = Content::find();
        //$query = Content::find()->joinWith('category');
        $query = Content::find()->joinWith('category')->joinWith('contentType');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'content.id'      => $this->id,
            'category_id'     => $this->category_id,
            'hits'            => $this->hits,
            'rating_sum'      => $this->rating_sum,
            'rating_count'    => $this->rating_count,
            'show_title'      => $this->show_title,
            'show_intro'      => $this->show_intro,
            'show_image'      => $this->show_image,
            'show_hits'       => $this->show_hits,
            'show_rating'     => $this->show_rating,
            'content_type_id' => $this->content_type_id,
            'featured'        => $this->featured,
            'ordering'        => $this->ordering,
            'publish_up'      => $this->publish_up,
            'publish_down'    => $this->publish_down,
            'status'          => $this->status,
            'created_by'      => $this->created_by,
            'created_at'      => $this->created_at,
            'updated_by'      => $this->updated_by,
            'updated_at'      => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content.title', $this->title])
            ->andFilterWhere(['like', 'LOWER(content_category.alias)', strtolower($this->category)])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'intro_text', $this->intro_text])
            ->andFilterWhere(['like', 'full_text', $this->full_text])
            ->andFilterWhere(['like', 'intro_image', $this->intro_image])
            ->andFilterWhere(['like', 'intro_image_float', $this->intro_image_float])
            ->andFilterWhere(['like', 'main_image', $this->main_image])
            ->andFilterWhere(['like', 'main_image_float', $this->main_image_float]);

        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCarousel($params)
    {
        //$query = Content::find();
        //$query = Content::find()->joinWith('category');
        //$query = Content::find()->joinWith('category')->joinWith('contentType')->where(['content_type_id' => 7]);  // 7 = carousel 
        //$query = Content::find()->joinWith(['category', 'contentType'])->where(['content_type_id' => 7]);  // 7 = carousel 
        $query = Content::find()->joinWith(['category', 'contentType'])->where(['content_type.alias' => 'carousel']);  

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'              => $this->id,
            'category_id'     => $this->category_id,
            'hits'            => $this->hits,
            'rating_sum'      => $this->rating_sum,
            'rating_count'    => $this->rating_count,
            'show_title'      => $this->show_title,
            'show_intro'      => $this->show_intro,
            'show_image'      => $this->show_image,
            'show_hits'       => $this->show_hits,
            'show_rating'     => $this->show_rating,
            'content_type_id' => $this->content_type_id,
            'featured'        => $this->featured,
            'ordering'        => $this->ordering,
            'publish_up'      => $this->publish_up,
            'publish_down'    => $this->publish_down,
            'status'          => $this->status,
            'created_by'      => $this->created_by,
            'created_at'      => $this->created_at,
            'updated_by'      => $this->updated_by,
            'updated_at'      => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content.title',   $this->title])
            ->andFilterWhere(['like', 'LOWER(content_category.alias)', strtolower($this->category)])
            ->andFilterWhere(['like', 'tags',              $this->tags])
            ->andFilterWhere(['like', 'intro_text',        $this->intro_text])
            ->andFilterWhere(['like', 'full_text',         $this->full_text])
            ->andFilterWhere(['like', 'intro_image',       $this->intro_image])
            ->andFilterWhere(['like', 'intro_image_float', $this->intro_image_float])
            ->andFilterWhere(['like', 'main_image',        $this->main_image])
            ->andFilterWhere(['like', 'main_image_float',  $this->main_image_float]);

        return $dataProvider;
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchMotd($params)
    {
        //$query = Content::find();
        //$query = Content::find()->joinWith('category');
        //$query = Content::find()->joinWith('category')->joinWith('contentType')->where(['content_type_id' => 7]);  // 7 = carousel 
        //$query = Content::find()->joinWith(['category', 'contentType'])->where(['content_type_id' => 7]);  // 7 = carousel 
        $query = Content::find()->joinWith(['category', 'contentType'])->where(['content_type.alias' => 'motd']);  

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'              => $this->id,
            'category_id'     => $this->category_id,
            'hits'            => $this->hits,
            'rating_sum'      => $this->rating_sum,
            'rating_count'    => $this->rating_count,
            'show_title'      => $this->show_title,
            'show_intro'      => $this->show_intro,
            'show_image'      => $this->show_image,
            'show_hits'       => $this->show_hits,
            'show_rating'     => $this->show_rating,
            'content_type_id' => $this->content_type_id,
            'featured'        => $this->featured,
            'ordering'        => $this->ordering,
            'publish_up'      => $this->publish_up,
            'publish_down'    => $this->publish_down,
            'status'          => $this->status,
            'created_by'      => $this->created_by,
            'created_at'      => $this->created_at,
            'updated_by'      => $this->updated_by,
            'updated_at'      => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content.title',   $this->title])
            ->andFilterWhere(['like', 'LOWER(content_category.alias)', strtolower($this->category)])
            ->andFilterWhere(['like', 'tags',              $this->tags])
            ->andFilterWhere(['like', 'intro_text',        $this->intro_text])
            ->andFilterWhere(['like', 'full_text',         $this->full_text])
            ->andFilterWhere(['like', 'intro_image',       $this->intro_image])
            ->andFilterWhere(['like', 'intro_image_float', $this->intro_image_float])
            ->andFilterWhere(['like', 'main_image',        $this->main_image])
            ->andFilterWhere(['like', 'main_image_float',  $this->main_image_float]);

        return $dataProvider;
    }
}
