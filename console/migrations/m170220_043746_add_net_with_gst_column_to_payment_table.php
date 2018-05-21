<?php

use yii\db\Migration;

/**
 * Handles adding net_with_gst to table `payment`.
 */
class m170220_043746_add_net_with_gst_column_to_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('payment', 'net_with_interest', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('payment', 'net_with_interest');
    }
}
