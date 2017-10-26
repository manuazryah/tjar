<?php

use yii\db\Migration;

/**
 * Class m171025_050846_create_table_vendor_location
 */
class m171025_050846_create_table_vendor_location extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%locations}}', [
            'id' => $this->primaryKey(),
            'vendor_id' => $this->integer()->Null(),
            'first_name' => $this->string(100)->Null(),
            'last_name' => $this->string(100)->Null(),
            'country' => $this->integer()->Null(),
            'city' => $this->integer()->Null(),
            'street' => $this->integer()->Null(),
            'building_no' => $this->string(300)->Null(),
            'mobile_no' => $this->integer()->Null(),
            'landline' => $this->integer()->Null(),
            'postbox_no' => $this->string(100)->Null(),
            'dafault_address' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%locations}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('vendor_id', 'locations', 'vendor_id', $unique = false);
        $this->addForeignKey("vendor-location", "locations", "vendor_id", "vendors", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171025_050846_create_table_vendor_location cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171025_050846_create_table_vendor_location cannot be reverted.\n";

      return false;
      }
     */
}
