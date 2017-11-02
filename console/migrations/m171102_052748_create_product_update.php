<?php

use yii\db\Migration;

/**
 * Class m171102_052748_create_product_update
 */
class m171102_052748_create_product_update extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $this->addColumn('products', 'short_description', 'varchar(500) after gender');
                $this->addColumn('products', 'short_description_arabic', 'varchar(500) after short_description');
                $this->addColumn('products', 'highlights', 'text after main_description_arabic');
                $this->addColumn('products', 'highlights_arabic', 'text after highlights');
                $this->addColumn('products', 'important_notes', 'text after highlights_arabic');
                $this->addColumn('products', 'important_notes_arabic', 'text after important_notes');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171102_052748_create_product_update cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171102_052748_create_product_update cannot be reverted.\n";

          return false;
          }
         */
}
