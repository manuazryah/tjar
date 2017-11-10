<?php

use yii\db\Migration;

/**
 * Class m171109_114857_create_product_mapping
 */
class m171109_114857_create_product_mapping extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_mapping}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->Null(),
            'subcategory' => $this->integer()->Null(),
            'product_id' => $this->string(500)->Null(),
            'variants' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_mapping}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category', 'product_mapping', 'category', $unique = false);
        $this->createIndex('subcategory', 'product_mapping', 'subcategory', $unique = false);
        $this->addForeignKey("product_mapping-category", "product_mapping", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("product_mapping-subcategory", "product_mapping", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171109_114857_create_product_mapping cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171109_114857_create_product_mapping cannot be reverted.\n";

      return false;
      }
     */
}
