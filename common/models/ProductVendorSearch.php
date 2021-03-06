<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductVendor;

/**
 * ProductVendorSearch represents the model behind the search form of `common\models\ProductVendor`.
 */
class ProductVendorSearch extends ProductVendor {

    public $compare; //compare value
    public $compareOp; //compare operator, for example [>,<,>=,<=]

    /**
     * @inheritdoc
     */

    public function rules() {
        return [
            [['id', 'product_id', 'vendor_id', 'qty', 'sku', 'handling_time', 'pick_up_location', 'free_shipping', 'courier_handover', 'full_fill', 'vendor_status', 'admin_status', 'CB', 'UB'], 'integer'],
            [['offer_price'], 'number'],
            [['offer_note', 'conditions', 'field1', 'field2', 'field3', 'DOC', 'DOU', 'price', 'compare', 'compareOp', 'offer'], 'safe'],
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
        $query = ProductVendor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!isset($params["ProductVendor"]["compareOp"])) {
            $operator = '';
        } else {
            $operator = $params["ProductVendor"]["compareOp"];
        }
        if (!isset($params["ProductVendor"]["compare"])) {
            $val = '';
        } else {
            $val = $params["ProductVendor"]["compare"];
        }


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
            'qty' => $this->qty,
            'sku' => $this->sku,
            'offer' => $this->offer,
            'handling_time' => $this->handling_time,
            'pick_up_location' => $this->pick_up_location,
            'free_shipping' => $this->free_shipping,
            'courier_handover' => $this->courier_handover,
            'offer_price' => $this->offer_price,
            'full_fill' => $this->full_fill,
            'vendor_status' => $this->vendor_status,
            'admin_status' => $this->admin_status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'offer_note', $this->offer_note])
                ->andFilterWhere(['like', 'conditions', $this->conditions])
                ->andFilterWhere([$operator, 'price', $val])
                ->andFilterWhere(['like', 'field1', $this->field1])
                ->andFilterWhere(['like', 'field2', $this->field2])
                ->andFilterWhere(['like', 'field3', $this->field3]);

        return $dataProvider;
    }

}
