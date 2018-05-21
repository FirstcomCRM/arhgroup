<?php

use yii\db\Migration;

class m170310_031327_add_discount_amount_and_discount_remarks_to_quotation_table extends Migration
{
    public function up()
    {
        $this->addColumn('quotation', 'discount_amount', $this->double(10,2)->notNull());
        $this->addColumn('quotation', 'discount_remarks', $this->text()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('quotation', 'discount_amount');
        $this->dropColumn('quotation', 'discount_remarks');
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
