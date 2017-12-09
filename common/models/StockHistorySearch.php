<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockHistory;

/**
 * StockHistorySearch represents the model behind the search form about `common\models\StockHistory`.
 */
class StockHistorySearch extends StockHistory {

        public $createdFrom;
        public $createdTo;

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'products_id', 'user_id', 'productvendor_id', 'usertype', 'qty', 'total_stock', 'purpose'], 'integer'],
                        [['DOC'], 'safe'],
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
                if (isset($params["StockHistorySearch"]["createdFrom"]) && $params["StockHistorySearch"]["createdFrom"] != '') {
                        $params["StockHistorySearch"]["createdFrom"] = $params["StockHistorySearch"]["createdFrom"] . ' 00:00:00';
                } else {
                        $params["StockHistorySearch"]["createdFrom"] = '';
                }
                if (isset($params["StockHistorySearch"]["createdTo"]) && $params["StockHistorySearch"]["createdTo"] != '') {
                        $params["StockHistorySearch"]["createdTo"] = $params["StockHistorySearch"]["createdTo"] . ' 60:60:60';
                } else {
                        $params["StockHistorySearch"]["createdTo"] = '';
                }
                $query = StockHistory::find();
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
                    'products_id' => $this->products_id,
                    'user_id' => $this->user_id,
//            'productvendor_id' => $this->productvendor_id,
                    'usertype' => $this->usertype,
                    'qty' => $this->qty,
                    'total_stock' => $this->total_stock,
                    'purpose' => $this->purpose,
                    'DOC' => $this->DOC,
                ]);
                $query
//                ->andFilterWhere(['like', 'order_id', $this->order_id])
                        ->andFilterWhere(['>=', 'DOC', $params["StockHistorySearch"]["createdFrom"]])
                        ->andFilterWhere(['<=', 'DOC', $params["StockHistorySearch"]["createdTo"]]);

                return $dataProvider;
        }

}
