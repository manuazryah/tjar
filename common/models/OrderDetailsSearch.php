<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderDetails;

/**
 * OrderDetailsSearch represents the model behind the search form about `common\models\OrderDetails`.
 */
class OrderDetailsSearch extends OrderDetails {

    public $createdFrom;
    public $createdTo;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'master_id', 'product_id', 'quantity', 'status', 'user_id', 'payment_status', 'admin_status'], 'integer'],
            [['order_id', 'delivered_date', 'DOC'], 'safe'],
            [['amount', 'sub_total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        if (isset($params["OrderDetailsSearch"]["createdFrom"]) && $params["OrderDetailsSearch"]["createdFrom"] != '') {
            $params["OrderDetailsSearch"]["createdFrom"] = $params["OrderDetailsSearch"]["createdFrom"] . ' 00:00:00';
        } else {
            $params["OrderDetailsSearch"]["createdFrom"] = '';
        }
        if (isset($params["OrderDetailsSearch"]["createdTo"]) && $params["OrderDetailsSearch"]["createdTo"] != '') {
            $params["OrderDetailsSearch"]["createdTo"] = $params["OrderDetailsSearch"]["createdTo"] . ' 60:60:60';
        } else {
            $params["OrderDetailsSearch"]["createdTo"] = '';
        }

        $query = OrderDetails::find()->orderBy(['id' => SORT_DESC]);

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
            'master_id' => $this->master_id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'sub_total' => $this->sub_total,
            'delivered_date' => $this->delivered_date,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'admin_status' => $this->admin_status,
//            'DOC' => $this->DOC,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
                ->andFilterWhere(['>=', 'DOC', $params["OrderDetailsSearch"]["createdFrom"]])
                ->andFilterWhere(['<=', 'DOC', $params["OrderDetailsSearch"]["createdTo"]]);

        return $dataProvider;
    }

}
