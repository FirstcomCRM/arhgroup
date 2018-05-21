<?php

use yii\db\Migration;

/**
 * Handles adding payment_status to table `payment`.
 */
class m170218_080155_add_payment_status_column_to_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('payment', 'payment_status', $this->integer(5)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('payment', 'payment_status');
    }
}
