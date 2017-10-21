<?php

use yii\db\Migration;

/**
 * Class m171020_101645_table_brand
 */
class m171020_101645_table_brand extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%product_brand}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'brand_name' => $this->string(500)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%product_brand}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'product_brand', 'main_category', $unique = false);
        $this->createIndex('category', 'product_brand', 'category', $unique = false);
        $this->createIndex('subcategory', 'product_brand', 'subcategory', $unique = false);
        $this->addForeignKey("product_maincategory", "product_brand", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("productcategory", "product_brand", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("product_subcategory", "product_brand", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171020_101645_table_brand cannot be reverted.\n";
        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {
      }
      public function down()
      {
      echo "m171020_101645_table_brand cannot be reverted.\n";
      return false;
      }
     */
}
