<?php

use yii\db\Migration;

/**
 * Class m171026_044947_create_table_locationmaster
 */
class m171026_044947_create_table_locationmaster extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'country_name' => $this->string(100)->Null(),
            'country_name_arabic' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%country}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->insert('country', ['country_name' => 'Qatar', 'country_name_arabic' => 'دولة قطر', 'status' => '1', 'CB' => '1', 'UB' => '1', 'DOC' => '2017-10-20', 'DOU' => '2017-10-20 16:11:28']);

        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->Null(),
            'city_name' => $this->string(100)->Null(),
            'city_name_arabic' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%city}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('country_id', 'city', 'country_id', $unique = false);
        $this->addForeignKey("city-country", "city", "country_id", "country", "id", "RESTRICT", "RESTRICT");

        $this->createTable('{{%street}}', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer()->Null(),
            'city_id' => $this->integer()->Null(),
            'street_name' => $this->string(100)->Null(),
            'street_name_arabic' => $this->string(100)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%street}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');

        $this->createIndex('country_id', 'street', 'country_id', $unique = false);
        $this->createIndex('city_id', 'street', 'city_id', $unique = false);
        $this->addForeignKey("street_country", "street", "country_id", "country", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("street_city", "street", "city_id", "city", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171026_044947_create_table_locationmaster cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171026_044947_create_table_locationmaster cannot be reverted.\n";

      return false;
      }
     */
}
