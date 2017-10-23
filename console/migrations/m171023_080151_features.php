<?php

use yii\db\Migration;

/**
 * Class m171023_080151_features
 */
class m171023_080151_features extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%features}}', [
            'id' => $this->primaryKey(),
            'filter_tittle' => $this->string(500)->notNull(),
            'table_name' => $this->string(100)->Null(),
            'model_name' => $this->string(100)->Null(),
            'tablevalue__name' => $this->string(100)->Null(),
            'table_value_id' => $this->string(100)->Null(),
            'category' => $this->integer()->Null(),
            'comments' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%features}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171023_080151_features cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171023_080151_features cannot be reverted.\n";

      return false;
      }
     */
}
