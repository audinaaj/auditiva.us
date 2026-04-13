<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ContentCategory;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * ContentCategorySearch represents the model behind the search form about `app\models\ContentCategory`.
 */
class ContentCategorySearch extends ContentCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'show_title', 'show_intro', 'show_image', 'ordering', 'published', 'created_by', 'updated_by'], 'integer'],
            [['title', 'alias', 'intro_text', 'image', 'image_float', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,  // By default, TimestampBehavior will fill the created_at and updated_at attributes with the current timestamp
            BlameableBehavior::class,  // By default, BlameableBehavior will fill the created_by and updated_by attributes with the current user ID
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
        $query = ContentCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'         => $this->id,
            'show_title' => $this->show_title,
            'show_intro' => $this->show_intro,
            'show_image' => $this->show_image,
            'ordering'   => $this->ordering,
            'published'  => $this->published,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title',     $this->title])
            ->andFilterWhere(['like', 'alias',       $this->alias])
            ->andFilterWhere(['like', 'intro_text',  $this->intro_text])
            ->andFilterWhere(['like', 'image',       $this->image])
            ->andFilterWhere(['like', 'image_float', $this->image_float]);

        return $dataProvider;
    }
}
