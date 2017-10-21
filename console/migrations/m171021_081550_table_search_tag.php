<?php

use yii\db\Migration;

/**
 * Class m171021_081550_table_search_tag
 */
class m171021_081550_table_search_tag extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%search_tag}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'tag_name' => $this->string(500)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%search_tag}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('category', 'search_tag', 'category', $unique = false);
        $this->createIndex('subcategory', 'search_tag', 'subcategory', $unique = false);
        $this->addForeignKey("search_tag-category", "search_tag", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("search_tag-subcategory", "search_tag", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171021_081550_table_search_tag cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171021_081550_table_search_tag cannot be reverted.\n";

      return false;
      }
     */
}
