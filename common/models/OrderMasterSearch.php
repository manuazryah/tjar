<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderMaster;

/**
 * OrderMasterSearch represents the model behind the search form about `common\models\OrderMaster`.
 */
class OrderMasterSearch extends OrderMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'promotion_id', 'ship_address_id', 'bill_address_id', 'payment_status', 'admin_status', 'shipping_status', 'status'], 'integer'],
            [['order_id', 'order_date', 'user_comment', 'admin_comment', 'DOC', 'DOU'], 'safe'],
            [['total_amount', 'promotion_discount', 'discount_amount', 'net_amount'], 'number'],
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
        $query = OrderMaster::find();

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
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'promotion_id' => $this->promotion_id,
            'promotion_discount' => $this->promotion_discount,
            'discount_amount' => $this->discount_amount,
            'net_amount' => $this->net_amount,
            'order_date' => $this->order_date,
            'ship_address_id' => $this->ship_address_id,
            'bill_address_id' => $this->bill_address_id,
            'payment_status' => $this->payment_status,
            'admin_status' => $this->admin_status,
            'shipping_status' => $this->shipping_status,
            'status' => $this->status,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'user_comment', $this->user_comment])
            ->andFilterWhere(['like', 'admin_comment', $this->admin_comment]);

        return $dataProvider;
    }
}
