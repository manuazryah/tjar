<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vendors;

/**
 * VendorsSearch represents the model behind the search form about `common\models\Vendors`.
 */
class VendorsSearch extends Vendors {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'status', 'CB', 'UB'], 'integer'],
                        [['first_name', 'last_name', 'username', 'password', 'phone_number', 'mobile_number', 'email', 'DOC', 'DOU'], 'safe'],
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
                $query = Vendors::find()->orderBy(['id' => SORT_DESC]);

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
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'first_name', $this->first_name])
                        ->andFilterWhere(['like', 'last_name', $this->last_name])
                        ->andFilterWhere(['like', 'username', $this->username])
                        ->andFilterWhere(['like', 'password', $this->password])
                        ->andFilterWhere(['like', 'phone_number', $this->phone_number])
                        ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
                        ->andFilterWhere(['like', 'email', $this->email]);

                return $dataProvider;
        }

}
