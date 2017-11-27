<?php

use yii\db\Migration;

/**
 * Class m171103_101754_create_forgot_password
 */
class m171103_101754_create_forgot_password extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%forgot_password_tokens}}', [
                    'id' => $this->primaryKey(),
                    'user_id' => $this->integer(),
                    'token' => $this->string(225),
                    'type' => $this->integer(),
                    'date_time' => $this->timestamp(),
                        ], $tableOptions);
                $this->alterColumn('{{%forgot_password_tokens}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171103_101754_create_forgot_password cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171103_101754_create_forgot_password cannot be reverted.\n";

          return false;
          }
         */
}
