<?php

use yii\db\Migration;

/**
 * Class m171113_101643_create_slider
 */
class m171113_101643_create_slider extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'slider_image' => $this->string(50)->Null(),
            'slider_image_arabic' => $this->string(50)->Null(),
            'main_tittle' => $this->string(500)->Null(),
            'sub_tittle' => $this->string(500)->Null(),
            'slider_link' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%slider}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171113_101643_create_slider cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171113_101643_create_slider cannot be reverted.\n";

      return false;
      }
     */
}
