<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductBrand;

/**
 * ProductBrandSearch represents the model behind the search form about `common\models\ProductBrand`.
 */
class ProductBrandSearch extends ProductBrand {

        /**
         * @inheritdoc
         */
        public function rules() {
                return [
                        [['id', 'main_category', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
                        [['brand_name', 'brand_name_arabic', 'comments', 'canonical_name', 'DOC', 'DOU'], 'safe'],
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
                $query = ProductBrand::find()->orderBy(['id' => SORT_DESC]);

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
                    'main_category' => $this->main_category,
                    'category' => $this->category,
                    'subcategory' => $this->subcategory,
                    'status' => $this->status,
                    'CB' => $this->CB,
                    'UB' => $this->UB,
                    'DOC' => $this->DOC,
                    'DOU' => $this->DOU,
                ]);

                $query->andFilterWhere(['like', 'brand_name', $this->brand_name])
                        ->andFilterWhere(['like', 'canonical_name', $this->canonical_name])
                        ->andFilterWhere(['like', 'brand_name_arabic', $this->brand_name_arabic])
                        ->andFilterWhere(['like', 'comments', $this->comments]);

                return $dataProvider;
        }

}
