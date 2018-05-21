<?php

use yii\db\Migration;

/**
 * Handles adding net to table `payment`.
 */
class m170218_084658_add_net_column_to_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('payment', 'net', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('payment', 'net');
    }
}
