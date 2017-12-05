<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CommissionManagement;

/**
 * CommissionManagementSearch represents the model behind the search form about `common\models\CommissionManagement`.
 */
class CommissionManagementSearch extends CommissionManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'vendor_id', 'status'], 'integer'],
            [['order_id', 'DOC', 'DOU'], 'safe'],
            [['product_price', 'offer_price', 'commission'], 'number'],
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
        $query = CommissionManagement::find();

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
            'product_id' => $this->product_id,
            'vendor_id' => $this->vendor_id,
            'product_price' => $this->product_price,
            'offer_price' => $this->offer_price,
            'commission' => $this->commission,
            'status' => $this->status,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id]);

        return $dataProvider;
    }
}
