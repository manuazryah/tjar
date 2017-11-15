<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HomeManagement;

/**
 * HomeManagementSearch represents the model behind the search form about `common\models\HomeManagement`.
 */
class HomeManagementSearch extends HomeManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'sort_order', 'status', 'CB', 'UB'], 'integer'],
            [['tittle', 'product_id', 'image_1', 'image_1_arabic', 'link_1', 'image_2', 'image_2_arabic', 'link_2', 'image_3', 'image_3_arabic', 'link_3', 'DOC', 'DOU'], 'safe'],
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
        $query = HomeManagement::find();

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
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'tittle', $this->tittle])
            ->andFilterWhere(['like', 'product_id', $this->product_id])
            ->andFilterWhere(['like', 'image_1', $this->image_1])
            ->andFilterWhere(['like', 'image_1_arabic', $this->image_1_arabic])
            ->andFilterWhere(['like', 'link_1', $this->link_1])
            ->andFilterWhere(['like', 'image_2', $this->image_2])
            ->andFilterWhere(['like', 'image_2_arabic', $this->image_2_arabic])
            ->andFilterWhere(['like', 'link_2', $this->link_2])
            ->andFilterWhere(['like', 'image_3', $this->image_3])
            ->andFilterWhere(['like', 'image_3_arabic', $this->image_3_arabic])
            ->andFilterWhere(['like', 'link_3', $this->link_3]);

        return $dataProvider;
    }
}
