<?php

use yii\db\Migration;

/**
 * Class m171106_042241_settings
 */
class m171106_042241_settings extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
         $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(250)->notNull(),
            'value' => $this->bigInteger(),
            'prefix' => $this->string(250),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171106_042241_settings cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171106_042241_settings cannot be reverted.\n";

      return false;
      }
     */
}
