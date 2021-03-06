<?php

use yii\db\Migration;

/**
 * Class m171020_073620_product_categories
 */
class m171020_073620_product_categories extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_main_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'canonical_name' => $this->string(100)->notNull(),
            'name_arabic' => $this->string(100)->notNull(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_main_category}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createTable('{{%product_category}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'category_name' => $this->string(100)->notNull(),
            'canonical_name' => $this->string(100)->notNull(),
            'category_name_arabic' => $this->string(100)->notNull(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_category}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category_id', 'product_category', 'category_id', $unique = false);
        $this->addForeignKey("category", "product_category", "category_id", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->createTable('{{%product_sub_category}}', [
            'id' => $this->primaryKey(),
            'main_category_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'subcategory_name' => $this->string(100)->notNull(),
            'canonical_name' => $this->string(100)->notNull(),
            'subcategory_name_arabic' => $this->string(100)->notNull(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_sub_category}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('main_category_id', 'product_sub_category', 'main_category_id', $unique = false);
        $this->createIndex('category_id', 'product_sub_category', 'category_id', $unique = false);
        $this->addForeignKey("product_category", "product_sub_category", "main_category_id", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("productsub_category", "product_sub_category", "category_id", "product_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171020_073620_product_categories cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171020_073620_product_categories cannot be reverted.\n";

      return false;
      }
     */
}
