<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Filter;

/**
 * FilterSearch represents the model behind the search form about `common\models\Filter`.
 */
class FilterSearch extends Filter {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
                        [['features', 'comments', 'DOC', 'DOU'], 'safe'],
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
                $query = Filter::find()->orderBy(['id' => SORT_DESC]);

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
                    'subcategory' => $this->subcategory,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'features', $this->features])
                        ->andFilterWhere(['like', 'comments', $this->comments]);

                return $dataProvider;
        }

}
