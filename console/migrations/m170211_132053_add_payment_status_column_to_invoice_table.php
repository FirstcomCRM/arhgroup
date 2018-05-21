<?php

use yii\db\Migration;

/**
 * Handles adding payment_status to table `invoice`.
 */
class m170211_132053_add_payment_status_column_to_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('invoice', 'payment_status', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('invoice', 'payment_status');
    }
}
