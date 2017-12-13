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
		if (!isset($params["OrderMasterSearch"]["createdFrom"])) {
			$params["OrderMasterSearch"]["createdFrom"] = '';
		} else {
			$params["OrderMasterSearch"]["createdFrom"] = $params["OrderMasterSearch"]["createdFrom"] . ' 00:00:00';
		}
		if (!isset($params["OrderMasterSearch"]["createdTo"])) {
			$params["OrderMasterSearch"]["createdTo"] = '';
		} else {
			$params["OrderMasterSearch"]["createdTo"] = $params["OrderMasterSearch"]["createdTo"] . ' 60:60:60';
		}
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
		if (!empty($this->entry_date) && strpos($this->entry_date, '-') !== false) {
			list($start_date, $end_date) = explode(' - ', $this->entry_date);

			$query->andFilterWhere(['between', 'date(entry_date)', $start_date, $end_date]);
			$this->entry_date = "";
		}

		// grid filtering conditions
		$query->andFilterWhere([
		    'id' => $this->id,
		    'user_id' => $this->user_id,
		    'type_id' => $this->type_id,
		    'amount' => $this->amount,
//		    'entry_date' => $this->entry_date,
		    'credit_debit' => $this->credit_debit,
		    'balance_amount' => $this->balance_amount,
		    'reference_id' => $this->reference_id,
		    'field_2' => $this->field_2,
		]);

		$query->andFilterWhere(['like', 'comment', $this->comment]);

		return $dataProvider;
	}

}
