<?php

use yii\db\Migration;

/**
 * Class m171030_071857_create_user_address
 */
class m171030_071857_create_user_address extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_address}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->Null(),
            'first_name' => $this->string(100)->Null(),
            'last_name' => $this->string(100)->Null(),
            'country_id' => $this->integer()->Null(),
            'city_id' => $this->integer()->Null(),
            'street_id' => $this->integer()->Null(),
            'address' => $this->text()->Null(),
            'landmark' => $this->text()->Null(),
            'default_address' => $this->smallInteger()->notNull()->defaultValue(0),
            'pincode' => $this->integer()->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%user_address}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('user_id', 'user_address', 'user_id', $unique = false);
        $this->createIndex('country_id', 'user_address', 'country_id', $unique = false);
        $this->createIndex('city_id', 'user_address', 'city_id', $unique = false);
        $this->createIndex('street_id', 'user_address', 'street_id', $unique = false);
        $this->addForeignKey("address_user", "user_address", "user_id", "user", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("address_country", "user_address", "country_id", "country", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("address_street", "user_address", "street_id", "street", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("address_city", "user_address", "city_id", "city", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171030_071857_create_user_address cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171030_071857_create_user_address cannot be reverted.\n";

      return false;
      }
     */
}
