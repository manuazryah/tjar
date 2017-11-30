<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductCategory;

/**
 * ProductCategorySearch represents the model behind the search form about `common\models\ProductCategory`.
 */
class ProductCategorySearch extends ProductCategory {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'category_id', 'status', 'CB', 'UB'], 'integer'],
                        [['category_name', 'canonical_name', 'category_name_arabic', 'comments', 'DOC', 'DOU'], 'safe'],
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
                $query = ProductCategory::find()->orderBy(['id' => SORT_DESC]);

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
                    'category_id' => $this->category_id,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'category_name', $this->category_name])
                        ->andFilterWhere(['like', 'canonical_name', $this->canonical_name])
                        ->andFilterWhere(['like', 'category_name_arabic', $this->category_name_arabic])
                        ->andFilterWhere(['like', 'comments', $this->comments]);

                return $dataProvider;
        }

}
