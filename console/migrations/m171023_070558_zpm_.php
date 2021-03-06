<?php

use yii\db\Migration;

/**
 * Class m171023_070558_zpm_
 */
class m171023_070558_zpm_ extends Migration {

    /**
     * @inheritdoc
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        /*         * *zpm operating system***** */
        $this->createTable('{{%zpm_operating_system}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_operating_system}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_operating_system', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_operating_system', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_operating_system', 'subcategory', $unique = false);
        $this->addForeignKey("os_maincategory", "zpm_operating_system", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("os_category", "zpm_operating_system", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("os_subcategory", "zpm_operating_system", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * **processor brand ***** */
        $this->createTable('{{%zpm_processor}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_processor}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_processor', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_processor', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_processor', 'subcategory', $unique = false);
        $this->addForeignKey("processor_maincategory", "zpm_processor", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("processor_category", "zpm_processor", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("processor_subcategory", "zpm_processor", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * **Type ************* */
        $this->createTable('{{%zpm_type}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_type}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_type', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_type', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_type', 'subcategory', $unique = false);
        $this->addForeignKey("type_maincategory", "zpm_type", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("type_category", "zpm_type", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("type_subcategory", "zpm_type", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * *Screen Size ****** */
        $this->createTable('{{%zpm_screen_size}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_screen_size}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_screen_size', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_screen_size', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_screen_size', 'subcategory', $unique = false);
        $this->addForeignKey("screen_maincategory", "zpm_screen_size", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("screen_category", "zpm_screen_size", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("screen_subcategory", "zpm_screen_size", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * ***Color ******** */
        $this->createTable('{{%zpm_color}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_color}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_color', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_color', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_color', 'subcategory', $unique = false);
        $this->addForeignKey("color_maincategory", "zpm_color", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("color_category", "zpm_color", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("color_subcategory", "zpm_color", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * ***Screen Type***** */
        $this->createTable('{{%zpm_screen_type}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_screen_type}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_screen_type', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_screen_type', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_screen_type', 'subcategory', $unique = false);
        $this->addForeignKey("screen_type_maincategory", "zpm_screen_type", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("screen_type_category", "zpm_screen_type", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("screen_type_subcategory", "zpm_screen_type", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * *** Body Type ****** */
        $this->createTable('{{%zpm_body_type}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_body_type}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_body_type', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_body_type', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_body_type', 'subcategory', $unique = false);
        $this->addForeignKey("body_type_maincategory", "zpm_body_type", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("body_type_category", "zpm_body_type", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("body_type_subcategory", "zpm_body_type", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * **Sleeve******** */
        $this->createTable('{{%zpm_sleeve}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_sleeve}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_sleeve', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_sleeve', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_sleeve', 'subcategory', $unique = false);
        $this->addForeignKey("sleeve_type_maincategory", "zpm_sleeve", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("sleeve_type_category", "zpm_sleeve", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("sleeve_type_subcategory", "zpm_sleeve", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * *****Theme***** */
        $this->createTable('{{%zpm_theme}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_theme}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_theme', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_theme', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_theme', 'subcategory', $unique = false);
        $this->addForeignKey("theme_maincategory", "zpm_theme", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("theme_category", "zpm_theme", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("theme_subcategory", "zpm_theme", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");

        /*         * ***    Pattern   ***** */
        $this->createTable('{{%zpm_pattern}}', [
            'id' => $this->primaryKey(),
            'main_category' => $this->integer()->notNull(),
            'category' => $this->integer()->notNull(),
            'subcategory' => $this->integer()->Null(),
            'value' => $this->string(250)->notNull(),
            'value_arabic' => $this->string(250)->notNull(),
            'field1' => $this->string(500)->Null(),
            'field2' => $this->string(500)->Null(),
            'field3' => $this->string(500)->Null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'CB' => $this->integer()->notNull(),
            'UB' => $this->integer()->notNull(),
            'DOC' => $this->date(),
            'DOU' => $this->timestamp(),
                ], $tableOptions);
        $this->alterColumn('{{%zpm_pattern}}', 'id', $this->integer() . ' NOT NULL AUTO_INCREMENT');
        $this->createIndex('main_category', 'zpm_pattern', 'main_category', $unique = false);
        $this->createIndex('category', 'zpm_pattern', 'category', $unique = false);
        $this->createIndex('subcategory', 'zpm_pattern', 'subcategory', $unique = false);
        $this->addForeignKey("pattern_maincategory", "zpm_pattern", "main_category", "product_main_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("pattern_category", "zpm_pattern", "category", "product_category", "id", "RESTRICT", "RESTRICT");
        $this->addForeignKey("pattern_subcategory", "zpm_pattern", "subcategory", "product_sub_category", "id", "RESTRICT", "RESTRICT");
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171023_070558_zpm_ cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171023_070558_zpm_ cannot be reverted.\n";

      return false;
      }
     */
}
