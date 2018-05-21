<?php

use yii\db\Migration;

class m170221_033717_add_columns_to_customer_table extends Migration
{
    public function up()
    {
        $this->addColumn('customer', 'nric', $this->string(50)->notNull());
        $this->addColumn('customer', 'engine_no', $this->string(50)->notNull());
        $this->addColumn('customer', 'year_mfg', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('customer', 'nric');
        $this->dropColumn('customer', 'engine_no');
        $this->dropColumn('customer', 'year_mfg');
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
