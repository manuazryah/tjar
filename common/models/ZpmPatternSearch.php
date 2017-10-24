<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ZpmPattern;

/**
 * ZpmPatternSearch represents the model behind the search form about `common\models\ZpmPattern`.
 */
class ZpmPatternSearch extends ZpmPattern
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'main_category', 'category', 'subcategory', 'status', 'CB', 'UB'], 'integer'],
            [['value', 'value_arabic', 'field1', 'field2', 'field3', 'DOC', 'DOU'], 'safe'],
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
        $query = ZpmPattern::find();

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

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'value_arabic', $this->value_arabic])
            ->andFilterWhere(['like', 'field1', $this->field1])
            ->andFilterWhere(['like', 'field2', $this->field2])
            ->andFilterWhere(['like', 'field3', $this->field3]);

        return $dataProvider;
    }
}
