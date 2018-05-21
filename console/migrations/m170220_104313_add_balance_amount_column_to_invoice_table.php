<?php

use yii\db\Migration;

/**
 * Handles adding balance_amount to table `invoice`.
 */
class m170220_104313_add_balance_amount_column_to_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('invoice', 'balance_amount', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('invoice', 'balance_amount');
    }
}
