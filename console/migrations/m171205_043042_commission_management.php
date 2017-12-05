<?php

use yii\db\Migration;

/**
 * Class m171205_043042_commission_management
 */
class m171205_043042_commission_management extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%commission_management}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->Null(),
            'vendor_id' => $this->integer()->Null(),
            'order_id' => $this->string(500)->Null(),
            'product_price' => $this->decimal(10, 2)->Null(),
            'offer_price' => $this->decimal(10, 2)->Null(),
            'commission' => $this->decimal(10, 2)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171205_043042_commission_management cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171205_043042_commission_management cannot be reverted.\n";

      return false;
      }
     */
}
