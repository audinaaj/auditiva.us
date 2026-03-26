<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppSetting;

/**
 * AppSettingSearch represents the model behind the search form about `app\models\AppSetting`.
 */
class AppSettingSearch extends AppSetting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['key', 'value', 'default', 'status', 'type', 'unit', 'role', 'created_at', 'updated_at'], 'safe'],
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
        $query = AppSetting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'         => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'key',   $this->key])
            ->andFilterWhere(['like', 'value',   $this->value])
            ->andFilterWhere(['like', 'default', $this->default])
            ->andFilterWhere(['like', 'status',  $this->status])
            ->andFilterWhere(['like', 'type',    $this->type])
            ->andFilterWhere(['like', 'unit',    $this->unit])
            ->andFilterWhere(['like', 'role',    $this->role]);

        return $dataProvider;
    }
}
