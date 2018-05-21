<?php

use yii\db\Migration;

/**
 * Handles adding interest to table `payment`.
 */
class m170218_075614_add_interest_column_to_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('payment', 'interest', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('payment', 'interest');
    }
}
