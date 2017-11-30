<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Features;

/**
 * FeaturesSearch represents the model behind the search form about `common\models\Features`.
 */
class FeaturesSearch extends Features {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'category', 'status', 'CB', 'UB'], 'integer'],
                        [['filter_tittle', 'canonical_name', 'table_name', 'model_name', 'tablevalue__name', 'table_value_id', 'comments', 'DOC', 'DOU'], 'safe'],
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
                $query = Features::find()->orderBy(['id' => SORT_DESC]);

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
                    'category' => $this->category,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'filter_tittle', $this->filter_tittle])
                        ->andFilterWhere(['like', 'canonical_name', $this->canonical_name])
                        ->andFilterWhere(['like', 'table_name', $this->table_name])
                        ->andFilterWhere(['like', 'model_name', $this->model_name])
                        ->andFilterWhere(['like', 'tablevalue__name', $this->tablevalue__name])
                        ->andFilterWhere(['like', 'table_value_id', $this->table_value_id])
                        ->andFilterWhere(['like', 'comments', $this->comments]);

                return $dataProvider;
        }

}
