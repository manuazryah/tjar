<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_wallet".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type_id 1->add to wallet,2->from_wallet
 * @property string $amount
 * @property string $entry_date
 * @property int $credit_debit 1->credit,2->debit
 * @property string $balance_amount
 * @property int $reference_id
 * @property string $comment
 * @property int $field_2
 */
class UserWallet extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'user_wallet';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['user_id', 'type_id', 'credit_debit', 'reference_id', 'field_2'], 'integer'],
			[['type_id', 'credit_debit', 'amount', 'balance_amount', 'user_id', 'entry_date'], 'required'],
			[['amount', 'balance_amount'], 'number'],
			[['entry_date'], 'safe'],
			[['comment'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
		    'id' => 'ID',
		    'user_id' => 'User ID',
		    'type_id' => 'Type ID',
		    'amount' => 'Amount',
		    'entry_date' => 'Entry Date',
		    'credit_debit' => 'Credit Debit',
		    'balance_amount' => 'Balance Amount',
		    'reference_id' => 'Reference ID',
		    'comment' => 'Comment',
		    'field_2' => 'Field 2',
		];
	}

}
