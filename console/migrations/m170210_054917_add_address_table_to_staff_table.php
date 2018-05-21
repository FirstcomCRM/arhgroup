<?php

use yii\db\Migration;

class m170210_054917_add_address_table_to_staff_table extends Migration
{
    public function up()
    {
        $this->addColumn('staff', 'address', $this->text()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('staff', 'address');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
