<?php

use yii\db\Migration;

/**
 * Class m171024_035819_master_table
 */
class m171024_035819_master_table extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        /***master unit******/
        $this->createTable('{{%master_unit}}', [
            'id' => $this->primaryKey(),
            'unit_name' => $this->string(250)->notNull(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%master_unit}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171024_035819_master_table cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171024_035819_master_table cannot be reverted.\n";

      return false;
      }
     */
}
