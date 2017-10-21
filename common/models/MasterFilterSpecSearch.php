<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MasterFilterSpec;

/**
 * MasterFilterSpecSearch represents the model behind the search form about `common\models\MasterFilterSpec`.
 */
class MasterFilterSpecSearch extends MasterFilterSpec
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'CB', 'UB'], 'integer'],
            [['filter_tittle', 'table_name', 'model_name', 'tablevalue__name', 'table_value_id', 'DOC', 'DOU'], 'safe'],
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
        $query = MasterFilterSpec::find();

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

        $query->andFilterWhere(['like', 'filter_tittle', $this->filter_tittle])
            ->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'tablevalue__name', $this->tablevalue__name])
            ->andFilterWhere(['like', 'table_value_id', $this->table_value_id]);

        return $dataProvider;
    }
}
