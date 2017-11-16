<?php

use yii\db\Migration;

/**
 * Class m171114_055155_create_home_management
 */
class m171114_055155_create_home_management extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%home_management}}', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull()->defaultValue(0),
            'tittle' => $this->string(500)->Null(),
            'product_id' => $this->string(500)->Null(),
            'image_1' => $this->string(50)->Null(),
            'image_1_arabic' => $this->string(50)->Null(),
            'link_1' => $this->string(500)->Null(),
            'image_2' => $this->string(50)->Null(),
            'image_2_arabic' => $this->string(50)->Null(),
            'link_2' => $this->string(500)->Null(),
            'image_3' => $this->string(50)->Null(),
            'image_3_arabic' => $this->string(50)->Null(),
            'link_3' => $this->string(500)->Null(),
            'sort_order' => $this->integer()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%home_management}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171114_055155_create_home_management cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171114_055155_create_home_management cannot be reverted.\n";

      return false;
      }
     */
}
