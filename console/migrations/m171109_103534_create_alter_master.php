<?php

use yii\db\Migration;

/**
 * Class m171109_103534_create_alter_master
 */
class m171109_103534_create_alter_master extends Migration {

        /**
         * @inheritdoc
         */
        public function safeUp() {
                $this->addColumn('zpm_body_type', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_color', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_pattern', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_screen_type', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_sleeve', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_theme', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_type', 'canonical_name', 'VARCHAR(100) AFTER value');
                $this->addColumn('zpm_screen_size', 'canonical_name', 'VARCHAR(100) AFTER value');
        }

        /**
         * @inheritdoc
         */
        public function safeDown() {
                echo "m171109_103534_create_alter_master cannot be reverted.\n";

                return false;
        }

        /*
          // Use up()/down() to run migration code without a transaction.
          public function up()
          {

          }

          public function down()
          {
          echo "m171109_103534_create_alter_master cannot be reverted.\n";

          return false;
          }
         */
}
