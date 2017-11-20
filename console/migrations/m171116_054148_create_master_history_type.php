<?php

use yii\db\Migration;

/**
 * Class m171116_054148_create_master_history_type
 */
class m171116_054148_create_master_history_type extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('master_history_type', [
                    'id' => $this->primaryKey(),
                    'type' => $this->string(),
                    'content' => $this->text(),
                    'notification' => $this->string(250)->comment('1->Admin,2->Vendor,3->User'),
                    'status' => $this->integer(),
                    'CB' => $this->integer(),
                    'UB' => $this->integer(),
                    'DOC' => $this->dateTime(),
                    'DOU' => $this->timestamp(),
                ]);
                $this->insert('master_history_type', ['id' => '1', 'type' => 'Product Added', 'content' => 'added a product for approval', 'notification' => '1', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '2', 'type' => 'Product Approved', 'content' => 'Admin approved product', 'notification' => '2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '3', 'type' => 'Product Rejected', 'content' => 'Admin rejected product', 'notification' => '2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '4', 'type' => 'Order Placed', 'content' => 'new order placed', 'notification' => '1,2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '5', 'type' => 'Order Cancelled', 'content' => 'cancelled', 'notification' => '1,2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '6', 'type' => 'Product expired', 'content' => 'Product Validity expired', 'notification' => '2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
                $this->insert('master_history_type', ['id' => '7', 'type' => 'Stock out', 'content' => 'Stock out', 'notification' => '2', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);



                $this->createTable('history', [
                    'id' => $this->primaryKey(),
                    'reference_id' => $this->integer(),
                    'history_type' => $this->integer(),
                    'product_id' => $this->integer(),
                    'content' => $this->text(),
                    'date' => $this->date(),
                    'CB' => $this->integer()
                ]);
                $this->addForeignKey("history_type", "history", "history_type", "master_history_type", "id", "RESTRICT", "RESTRICT");

                $this->createTable('notification_view_status', [
                    'id' => $this->primaryKey(),
                    'reference_id' => $this->integer(),
                    'history_id' => $this->integer(),
                    'user_type' => $this->integer(),
                    'user_id' => $this->integer(),
                    'content' => $this->text(),
                    'view_status' => $this->integer()->comment('1->seen,0->unseen'),
                    'date' => $this->date(),
                ]);
                $this->addForeignKey("history_id", "notification_view_status", "history_id", "history", "id", "RESTRICT", "RESTRICT");
                $this->addCommentOnColumn('notification_view_status', 'user_type', '1->Admin,2->Vendor,3->User');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171116_054148_create_master_history_type cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171116_054148_create_master_history_type cannot be reverted.\n";

          return false;
          }
         */
}
