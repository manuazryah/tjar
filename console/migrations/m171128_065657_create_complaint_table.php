<?php

use yii\db\Migration;

/**
 * Handles the creation of table `complaint`.
 */
class m171128_065657_create_complaint_table extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user_complaints}}', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer()->Null(),
		    'product_id' => $this->integer()->Null(),
		    'vendor_id' => $this->integer()->Null(),
		    'complaint' => $this->text(),
		    'product_name' => $this->string(500)->Null(),
		    'status' => $this->smallInteger()->notNull()->defaultValue(1),
		    'CB' => $this->integer()->Null(),
		    'UB' => $this->integer()->Null(),
		    'DOC' => $this->date(),
		    'DOU' => $this->timestamp(),
			], $tableOptions);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		$this->dropTable('user_complaints');
	}

}
