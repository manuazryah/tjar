<?php

use yii\db\Migration;

/**
 * Class m171108_113716_create_temp_session
 */
class m171108_113716_create_temp_session extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%temp_session}}', [
                    'id' => $this->primaryKey(),
                    'session_id' => $this->string(),
                    'user_id' => $this->integer(),
                    'type_id' => $this->integer()->comment('1=Shipping Address,2=Billing Address,3=Coupon Code'),
                    'value' => $this->string(),
                        ], $tableOptions);
                $this->alterColumn('{{%temp_session}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171108_113716_create_temp_session cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171108_113716_create_temp_session cannot be reverted.\n";

          return false;
          }
         */
}
