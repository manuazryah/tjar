<?php

use yii\db\Migration;

/**
 * Class m171102_105419_create_customer_review
 */
class m171102_105419_create_customer_review extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%customer_reviews}}', [
                    'id' => $this->primaryKey(),
                    'user_id' => $this->integer()->notNull(),
                    'product_id' => $this->integer()->notNull(),
                    'title' => $this->text(),
                    'description' => $this->text(),
                    'review_date' => $this->date(),
                    'status' => $this->integer(),
                        ], $tableOptions);
                $this->addForeignKey('fk-customer_reviews-user_id', 'customer_reviews', 'user_id', 'user', 'id', 'CASCADE');
                $this->addForeignKey('fk-customer_reviews-product_id', 'customer_reviews', 'product_id', 'product_vendor', 'id', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171102_105419_create_customer_review cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171102_105419_create_customer_review cannot be reverted.\n";

          return false;
          }
         */
}
