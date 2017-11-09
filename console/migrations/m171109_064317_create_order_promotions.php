<?php

use yii\db\Migration;

/**
 * Class m171109_064317_create_order_promotions
 */
class m171109_064317_create_order_promotions extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%order_promotions}}', [
                    'id' => $this->primaryKey(),
                    'order_master_id' => $this->integer(),
                    'promotion_id' => $this->integer(),
                    'promotion_discount' => $this->decimal(10, 2),
                        ], $tableOptions);
                $this->alterColumn('{{%temp_session}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
                $this->addForeignKey('fk-order_promotions-order_master_id', 'order_promotions', 'order_master_id', 'order_master', 'id', 'CASCADE');
                $this->addForeignKey('fk-order_promotions-promotion_id', 'order_promotions', 'promotion_id', 'promotions', 'id', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171109_064317_create_order_promotions cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171109_064317_create_order_promotions cannot be reverted.\n";

          return false;
          }
         */
}
