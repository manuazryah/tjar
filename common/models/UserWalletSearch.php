<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserWallet;

/**
 * UserWalletSearch represents the model behind the search form about `common\models\UserWallet`.
 */
class UserWalletSearch extends UserWallet {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id', 'user_id', 'type_id', 'credit_debit', 'reference_id', 'field_2'], 'integer'],
			[['amount', 'balance_amount'], 'number'],
			[['entry_date', 'comment'], 'safe'],
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
		$query = UserWallet::find()->orderBy(['id' => SORT_DESC]);

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
		    'type_id' => $this->type_id,
		    'amount' => $this->amount,
		    'entry_date' => $this->entry_date,
		    'credit_debit' => $this->credit_debit,
		    'balance_amount' => $this->balance_amount,
		    'reference_id' => $this->reference_id,
		    'field_2' => $this->field_2,
		]);

		$query->andFilterWhere(['like', 'comment', $this->comment]);

		return $dataProvider;
	}

}
