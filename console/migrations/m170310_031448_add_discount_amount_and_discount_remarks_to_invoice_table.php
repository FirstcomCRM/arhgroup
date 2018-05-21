<?php

use yii\db\Migration;

class m170310_031448_add_discount_amount_and_discount_remarks_to_invoice_table extends Migration
{
    public function up()
    {
        $this->addColumn('invoice', 'discount_amount', $this->double(10,2)->notNull());
        $this->addColumn('invoice', 'discount_remarks', $this->text()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('invoice', 'discount_amount');
        $this->dropColumn('invoice', 'discount_remarks');
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
