<?php

use yii\db\Migration;

/**
 * Class m171021_052319_table_filter_specification
 */
class m171021_052319_table_filter_specification extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%master_filter_spec}}', [
            'id' => $this->primaryKey(),
            'filter_tittle' => $this->string(500)->notNull(),
            'table_name' => $this->string(100)->notNull(),
            'model_name' => $this->string(100)->notNull(),
            'tablevalue__name' => $this->string(100)->notNull(),
            'table_value_id' => $this->string(100)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%master_filter_spec}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171021_052319_table_filter_specification cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171021_052319_table_filter_specification cannot be reverted.\n";

      return false;
      }
     */
}
