<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MenuManagement;

/**
 * MenuManagementSearch represents the model behind the search form about `common\models\MenuManagement`.
 */
class MenuManagementSearch extends MenuManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'main_menu_id', 'sub_menu_id', 'status', 'CB', 'UB'], 'integer'],
            [['main_menu', 'main_menu_arabic', 'sub_menu', 'sub_menu_arabic', 'sub_menu_link', 'child_menu', 'child_menu_arabic', 'child_menu_link', 'DOC', 'DOU'], 'safe'],
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
        $query = MenuManagement::find();

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
            'main_menu_id' => $this->main_menu_id,
            'sub_menu_id' => $this->sub_menu_id,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'main_menu', $this->main_menu])
            ->andFilterWhere(['like', 'main_menu_arabic', $this->main_menu_arabic])
            ->andFilterWhere(['like', 'sub_menu', $this->sub_menu])
            ->andFilterWhere(['like', 'sub_menu_arabic', $this->sub_menu_arabic])
            ->andFilterWhere(['like', 'sub_menu_link', $this->sub_menu_link])
            ->andFilterWhere(['like', 'child_menu', $this->child_menu])
            ->andFilterWhere(['like', 'child_menu_arabic', $this->child_menu_arabic])
            ->andFilterWhere(['like', 'child_menu_link', $this->child_menu_link]);

        return $dataProvider;
    }
}
