<?php

use yii\db\Migration;

/**
 * Class m171024_105205_table_product_vendor
 */
class m171024_105205_table_product_vendor extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $tableOptions = null;
                if ($this->db->driverName === 'mysql') {
                        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
                }
                $this->createTable('{{%product_vendor}}', [
                    'id' => $this->primaryKey(),
                    'product_id' => $this->integer()->Null(),
                    'vendor_id' => $this->integer()->Null(),
                    'qty' => $this->integer()->Null(),
                    'price' => $this->decimal()->Null(),
                    'sku' => $this->integer()->Null(),
                    'offer_note' => $this->text()->Null(),
                    'handling_time' => $this->integer()->Null(),
                    'pick_up_location' => $this->integer()->Null(),
                    'free_shipping' => $this->integer()->Null(),
                    'free_shipping' => $this->integer()->Null(),
                    'courier_handover' => $this->integer()->Null(),
                    'conditions' => $this->text()->Null(),
                    'offer_price' => $this->decimal()->Null(),
                    'full_fill' => $this->integer()->Null(),
                    'warranty' => $this->string(500)->Null(),
                    'field1' => $this->string(500)->Null(),
                    'field2' => $this->string(500)->Null(),
                    'field3' => $this->string(500)->Null(),
                    'status' => $this->smallInteger()->notNull()->defaultValue(0),
                    'CB' => $this->integer()->notNull(),
                    'UB' => $this->integer()->notNull(),
                    'DOC' => $this->date(),
                    'DOU' => $this->timestamp(),
                        ], $tableOptions);
                $this->alterColumn('{{%product_vendor}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

                $this->createIndex('product_id', 'product_vendor', 'product_id', $unique = false);
                $this->createIndex('vendor_id', 'product_vendor', 'vendor_id', $unique = false);
                $this->addForeignKey("vendor-product_id", "product_vendor", "product_id", "products", "id", "RESTRICT", "RESTRICT");
                $this->addForeignKey("vendors-id", "product_vendor", "vendor_id", "vendors", "id", "RESTRICT", "RESTRICT");
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171024_105205_table_product_vendor cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171024_105205_table_product_vendor cannot be reverted.\n";

          return false;
          }
         */
}
