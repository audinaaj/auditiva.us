<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\models\Payment;

/**
 * PaymentSearch represents the model behind the search form about `app\models\Payment`.
 */
class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'created_by', 'updated_by'], 'integer'],
            [[
                'full_name', 'company_name', 'address', 'city', 'state_prov', 'postal_code', 'country', 
                'email', 'phone', 'fax', 'account_number', 'amount', 'description', 
                'payment_date', 'payment_status', 
                'crcard_type', 'crcard_number', 'crcard_first_name', 'crcard_last_name', 
                'trans_id', 'trans_invoice_num', 'trans_description', 'trans_response', 
                'ip_address', 'notes', 'created_at', 'updated_at'
            ], 'safe'],
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
        $query = Payment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => $this->active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state_prov', $this->state_prov])
            ->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'payment_status', $this->payment_status])
            ->andFilterWhere(['like', 'crcard_type', $this->crcard_type])
            ->andFilterWhere(['like', 'crcard_number', $this->crcard_number])
            ->andFilterWhere(['like', 'crcard_first_name', $this->crcard_first_name])
            ->andFilterWhere(['like', 'crcard_last_name', $this->crcard_last_name])
            ->andFilterWhere(['like', 'trans_id', $this->trans_id])
            ->andFilterWhere(['like', 'trans_invoice_num', $this->trans_invoice_num])
            ->andFilterWhere(['like', 'trans_description', $this->trans_description])
            ->andFilterWhere(['like', 'trans_response', $this->trans_response])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
