<?php

use yii\db\Migration;

/**
 * Class m171214_050229_tbl_policies
 */
class m171214_050229_tbl_policies extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%policies}}', [
            'id' => $this->primaryKey(),
            'return_policy' => $this->text()->Null(),
            'terms_of_use' => $this->text()->Null(),
            'security' => $this->text()->Null(),
            'privacy' => $this->text()->Null(),
            'infringement' => $this->text()->Null(),
            'faq' => $this->text()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%policies}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171214_050229_tbl_policies cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171214_050229_tbl_policies cannot be reverted.\n";

      return false;
      }
     */
}
