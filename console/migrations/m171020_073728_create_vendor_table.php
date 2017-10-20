<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vendor`.
 */
class m171020_073728_create_vendor_table extends Migration {

        /**
         * @inheritdoc
         */
        public function up() {

                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }

                $this->createTable('vendors', [
                    'id' => $this->primaryKey(),
                    'name' => $this->string(280),
                    'username' => $this->string(),
                    'password' => $this->string(),
                    'address' => $this->string(),
                    'city' => $this->string(),
                    'post_code' => $this->integer(),
                    'phone_number' => $this->string(),
                    'mobile_number' => $this->string(),
                    'email' => $this->string(),
                    'auth_key' => $this->string(32),
                    'bank_account_details' => $this->text(),
                    'status' => $this->integer(),
                    'CB' => $this->integer(),
                    'UB' => $this->integer(),
                    'DOC' => $this->dateTime(),
                    'DOU' => $this->timestamp(),
                ]);
                $this->insert('vendors', ['id' => '1', 'name' => 'Testing', 'username' => '123', 'password' => '$2y$13$RS.hkV5A0BeKtCGGzql6yO7lZ2MblwFkNxxixzsf3NbuZwFphLhyi', 'address' => '', 'city' => '', 'post_code' => '', 'phone_number' => '', 'mobile_number' => '', 'email' => '', 'auth_key' => '', 'bank_account_details' => '', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);
        }

        /**
         * @inheritdoc
         */
        public function down() {
                $this->dropTable('vendor');
        }

}
