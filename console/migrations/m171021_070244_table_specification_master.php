<?php

use yii\db\Migration;

/**
 * Class m171021_070244_table_specification_master
 */
class m171021_070244_table_specification_master extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%specification_master}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'specification' => $this->integer()->notNull(),
            'specification_type' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%specification_master}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category', 'specification_master', 'category', $unique = false);
        $this->createIndex('subcategory', 'specification_master', 'subcategory', $unique = false);
        $this->createIndex('specification', 'specification_master', 'specification', $unique = false);
        $this->addForeignKey("specification-category", "specification_master", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("specification-subcategory", "specification_master", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("specification-id", "specification_master", "specification", "master_filter_spec", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171021_070244_table_specification_master cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171021_070244_table_specification_master cannot be reverted.\n";

      return false;
      }
     */
}
