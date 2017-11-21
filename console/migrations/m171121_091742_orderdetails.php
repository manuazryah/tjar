<?php

use yii\db\Migration;

/**
 * Class m171121_091742_orderdetails
 */
class m171121_091742_orderdetails extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_history}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->string(250)->notNull(),
            'product_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'date' => $this->dateTime(),
            'comment' => $this->text(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171121_091742_orderdetails cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171121_091742_orderdetails cannot be reverted.\n";

      return false;
      }
     */
}
