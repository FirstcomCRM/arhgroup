<?php

use yii\db\Migration;

class m170215_073339_add_columns_to_invoice_table extends Migration
{
    public function up()
    {
        $this->addColumn('invoice', 'mileage', $this->string(50)->notNull());
        $this->addColumn('invoice', 'gst', $this->double(10,2)->notNull());
        $this->addColumn('invoice', 'net', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('invoice', 'mileage');
        $this->dropColumn('invoice', 'gst');
        $this->dropColumn('invoice', 'net');
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
