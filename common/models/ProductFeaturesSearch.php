<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductFeatures;

/**
 * ProductFeaturesSearch represents the model behind the search form about `common\models\ProductFeatures`.
 */
class ProductFeaturesSearch extends ProductFeatures {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'category', 'subcategory', 'specification', 'specification_type', 'status', 'CB', 'UB'], 'integer'],
                        [['comments', 'DOC', 'DOU'], 'safe'],
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
                $query = ProductFeatures::find()->orderBy(['id' => SORT_DESC]);

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
                    'specification' => $this->specification,
                    'specification_type' => $this->specification_type,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'comments', $this->comments]);

                return $dataProvider;
        }

}
