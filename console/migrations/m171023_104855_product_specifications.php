<?php

use yii\db\Migration;

/**
 * Class m171023_104855_product_specifications
 */
class m171023_104855_product_specifications extends Migration {

	/**
	 * @inheritdoc
	 */
	public function safeUp() {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%product_specifications}}', [
		    'id' => $this->primaryKey(),
		    'product_id' => $this->integer()->notNull(),
		    'product_feature_id' => $this->integer()->Null(),
		    'product_feature_value' => $this->string(500)->Null(),
		    'Product_feature_text' => $this->string(500)->Null(),
		    'comments' => $this->text()->Null(),
		    'status' => $this->smallInteger()->notNull()->defaultValue(0),
		    'CB' => $this->integer()->notNull(),
		    'UB' => $this->integer()->notNull(),
		    'DOC' => $this->date(),
		    'DOU' => $this->timestamp(),
			], $tableOptions);
		$this->alterColumn('{{%product_features}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

		$this->createIndex('product_id', 'product_specifications', 'product_id', $unique = false);
		$this->createIndex('product_feature_id', 'product_specifications', 'product_feature_id', $unique = false);
		$this->addForeignKey("specification-product", "product_specifications", "product_id", "products", "id", "RESTRICT", "RESTRICT");
		$this->addForeignKey("specification-featured", "product_specifications", "product_feature_id", "product_features", "id", "RESTRICT", "RESTRICT");
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown() {
		echo "m171023_104855_product_specifications cannot be reverted.\n";

		return false;
	}

	/*
	  // Use up()/down() to run migration code without a transaction.
	  public function up()
	  {

	  }

	  public function down()
	  {
	  echo "m171023_104855_product_specifications cannot be reverted.\n";

	  return false;
	  }
	 */
}
