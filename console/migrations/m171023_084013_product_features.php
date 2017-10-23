<?php

use yii\db\Migration;

/**
 * Class m171023_084013_product_features
 */
class m171023_084013_product_features extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_features}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'specification' => $this->integer()->notNull(),
            'specification_type' => $this->integer()->notNull(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_features}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category', 'product_features', 'category', $unique = false);
        $this->createIndex('subcategory', 'product_features', 'subcategory', $unique = false);
        $this->createIndex('specification', 'product_features', 'specification', $unique = false);
        $this->addForeignKey("specification-category", "product_features", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("specification-subcategory", "product_features", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("specification-id", "product_features", "specification", "features", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171023_084013_product_features cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171023_084013_product_features cannot be reverted.\n";

      return false;
      }
     */
}
