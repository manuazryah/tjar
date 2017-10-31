<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserAddress;

/**
 * UserAddressSearch represents the model behind the search form of `common\models\UserAddress`.
 */
class UserAddressSearch extends UserAddress {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id', 'country_id', 'city_id', 'street_id', 'default_address', 'pincode', 'status', 'CB', 'UB'], 'integer'],
            [['first_name', 'last_name', 'address', 'landmark', 'DOC', 'DOU', 'phone'], 'safe'],
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
        $query = UserAddress::find();

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
            'user_id' => $this->user_id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'street_id' => $this->street_id,
            'phone' => $this->phone,
            'default_address' => $this->default_address,
            'pincode' => $this->pincode,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'landmark', $this->landmark]);

        return $dataProvider;
    }

}
