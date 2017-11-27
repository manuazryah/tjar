<?php

use yii\db\Migration;

/**
 * Class m171124_060340_stock
 */
class m171124_060340_stock extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%stock_history}}', [
            'id' => $this->primaryKey(),
            'products_id' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'productvendor_id' => $this->integer()->notNull(),
            'usertype' => $this->integer()->notNull()->comment('1=Admin,2=vendor,3=customer'),
            'qty' => $this->integer()->notNull(),
            'total_stock' => $this->integer(),
            'purpose' => $this->integer()->comment('1=Stock Added,2=Stock Changed,3=Stock Saled,4=Stock Returned'),
            'DOC' => $this->timestamp(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171124_060340_stock cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171124_060340_stock cannot be reverted.\n";

      return false;
      }
     */
}
