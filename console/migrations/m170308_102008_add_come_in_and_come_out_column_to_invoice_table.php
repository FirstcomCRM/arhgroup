<?php

use yii\db\Migration;

/**
 * Handles adding come_in_and_come_out to table `invoice`.
 */
class m170308_102008_add_come_in_and_come_out_column_to_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('invoice', 'come_in', $this->datetime()->notNull());
        $this->addColumn('invoice', 'come_out', $this->datetime()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('invoice', 'come_in');
        $this->dropColumn('invoice', 'come_out');
    }
}
