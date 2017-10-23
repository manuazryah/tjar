<?php

use yii\db\Migration;

/**
 * Class m171021_054946_table_filter
 */
class m171021_054946_table_filter extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%filter}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'features' => $this->string(300)->notNull(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%filter}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category', 'filter', 'category', $unique = false);
        $this->createIndex('subcategory', 'filter', 'subcategory', $unique = false);
        $this->addForeignKey("filter-category", "filter", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("filter-subcategory", "filter", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171021_054946_table_filter cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171021_054946_table_filter cannot be reverted.\n";

      return false;
      }
     */
}
