<?php

use yii\db\Migration;

/**
 * Handles adding come_in_and_come_out to table `quotation`.
 */
class m170308_101940_add_come_in_and_come_out_column_to_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'come_in', $this->datetime()->notNull());
        $this->addColumn('quotation', 'come_out', $this->datetime()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('quotation', 'come_in');
        $this->dropColumn('quotation', 'come_out');
    }
}
