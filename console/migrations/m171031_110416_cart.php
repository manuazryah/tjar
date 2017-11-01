<?php

use yii\db\Migration;

/**
 * Class m171031_110416_cart
 */
class m171031_110416_cart extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'session_id' => $this->string(225),
            'product_id' => $this->integer(),
            'quantity' => $this->integer(),
            'options' => $this->integer(),
            'date' => $this->dateTime(),
            'gift_option' => $this->integer(),
            'rate' => $this->double(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171031_110416_cart cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171031_110416_cart cannot be reverted.\n";

      return false;
      }
     */
}
