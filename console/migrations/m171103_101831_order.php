<?php

use yii\db\Migration;

/**
 * Class m171103_101831_order
 */
class m171103_101831_order extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order_master}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->string(250)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'total_amount' => $this->decimal(10, 0)->notNull(),
            'promotion_id' => $this->integer(),
            'promotion_discount' => $this->decimal(10, 0),
            'discount_amount' => $this->decimal(10, 0),
            'net_amount' => $this->decimal(10, 0)->notNull(),
            'order_date' => $this->dateTime(),
            'ship_address_id' => $this->integer(),
            'bill_address_id' => $this->integer(),
            'user_comment' => $this->text(),
            'admin_comment' => $this->text(),
            'payment_status' => $this->integer(),
            'admin_status' => $this->integer(),
            'shipping_status' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);

        $this->createTable('{{%order_details}}', [
            'id' => $this->primaryKey(),
            'master_id' => $this->integer()->notNull(),
            'order_id' => $this->string(250)->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 0)->notNull(),
            'sub_total' => $this->decimal(10, 0)->notNull(),
            'delivered_date'=>$this->date(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'DOC' => $this->date(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171103_101831_order cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171103_101831_order cannot be reverted.\n";

      return false;
      }
     */
}
