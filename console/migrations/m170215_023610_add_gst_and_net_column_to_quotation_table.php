<?php

use yii\db\Migration;

/**
 * Handles adding gst_and_net to table `quotation`.
 */
class m170215_023610_add_gst_and_net_column_to_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'gst', $this->double(10,2)->notNull());
        $this->addColumn('quotation', 'net', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('quotation', 'gst');
        $this->dropColumn('quotation', 'net');
    }
}
