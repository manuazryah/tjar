<?php

use yii\db\Migration;

/**
 * Class m171103_081152_create_recently_viewed
 */
class m171103_081152_create_recently_viewed extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%recently_viewed}}', [
                    'id' => $this->primaryKey(),
                    'user_id' => $this->integer(),
                    'session_id' => $this->string(250),
                    'product_id' => $this->integer(),
                    'date' => $this->date(),
                        ], $tableOptions);
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171103_081152_create_recently_viewed cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171103_081152_create_recently_viewed cannot be reverted.\n";

          return false;
          }
         */
}
