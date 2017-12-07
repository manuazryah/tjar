<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wallet`.
 */
class m171207_043419_create_user_wallet_table extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user_wallet}}', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer()->Null(),
		    'type_id' => $this->smallInteger()->notNull()->comment('1->add to wallet,2->from_wallet'),
		    'amount' => $this->decimal()->Null(),
		    'entry_date' => $this->date(),
		    'credit_debit' => $this->smallInteger()->notNull()->comment('1->credit,2->debit'),
		    'balance_amount' => $this->decimal()->Null(),
		    'reference_id' => $this->integer()->Null(),
		    'comment' => $this->text()->Null(),
		    'field_2' => $this->integer()->Null(),
			], $tableOptions);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		echo "m171207_043419_create_user_wallet_table cannot be reverted.\n";
		return false;
	}

}
