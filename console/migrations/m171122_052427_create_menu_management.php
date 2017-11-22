<?php

use yii\db\Migration;

/**
 * Class m171122_052427_create_menu_management
 */
class m171122_052427_create_menu_management extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu_management}}', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull()->comment('1->Main,2->Sub,3->child'),
            'main_menu_id' => $this->integer()->Null(),
            'main_menu' => $this->string(500)->Null(),
            'main_menu_arabic' => $this->string(500)->Null(),
            'sub_menu_id' => $this->integer()->Null(),
            'sub_menu' => $this->string(500)->Null(),
            'sub_menu_arabic' => $this->string(500)->Null(),
            'sub_menu_link' => $this->string(1000)->Null(),
            'child_menu' => $this->string(500)->Null(),
            'child_menu_arabic' => $this->string(500)->Null(),
            'child_menu_link' => $this->string(1000)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->Null(),
            'UB' => $this->integer()->Null(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%menu_management}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171122_052427_create_menu_management cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171122_052427_create_menu_management cannot be reverted.\n";

      return false;
      }
     */
}
