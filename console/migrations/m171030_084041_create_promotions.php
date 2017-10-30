<?php

use yii\db\Migration;

/**
 * Class m171030_084041_create_promotions
 */
class m171030_084041_create_promotions extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('{{%promotions}}', [
                    'id' => $this->primaryKey(),
                    'promotion_type' => $this->integer(),
                    'promotion_code' => $this->string(),
                    'product_id' => $this->string(),
                    'user_id' => $this->string(),
                    'type' => $this->integer()->comment('1=percentage,2=fixed'),
                    'price' => $this->decimal(10, 2),
                    'amount_range' => $this->string(),
                    'time' => $this->integer(),
                    'code_usage' => $this->integer()->comment('1=one time,2=multiple use'),
                    'starting_date' => $this->date(),
                    'expiry_date' => $this->date(),
                    'code_used' => $this->string(),
                    'status' => $this->smallInteger(),
                    'CB' => $this->integer()->notNull(),
                    'UB' => $this->integer()->notNull(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171030_084041_create_promotions cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171030_084041_create_promotions cannot be reverted.\n";

          return false;
          }
         */
}
