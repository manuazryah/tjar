<?php

use yii\db\Migration;

/**
 * Class m171116_054148_create_master_history_type
 */
class m171116_054148_create_master_history_type extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171116_054148_create_master_history_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171116_054148_create_master_history_type cannot be reverted.\n";

        return false;
    }
    */
}
