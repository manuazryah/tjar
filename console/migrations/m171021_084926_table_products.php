<?php

use yii\db\Migration;

/**
 * Class m171021_084926_table_products
 */
class m171021_084926_table_products extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'product_name' => $this->string(500)->notNull(),
            'canonical_name' => $this->string(500)->notNull(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'brand' => $this->integer()->notNull(),
            'item_ean' => $this->string(500)->notNull(),
            'gender' => $this->integer()->notNull(),
            'main_description' => $this->text()->notNull(),
            'gallery_images' => $this->string(500)->Null(),
            'related_products' => $this->string(500)->Null(),
            'search_tags' => $this->string(500)->Null(),
            'meta_title' => $this->string(500)->Null(),
            'meta_description' => $this->text()->Null(),
            'meta_keyword' => $this->text()->Null(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%products}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171021_084926_table_products cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171021_084926_table_products cannot be reverted.\n";

      return false;
      }
     */
}
