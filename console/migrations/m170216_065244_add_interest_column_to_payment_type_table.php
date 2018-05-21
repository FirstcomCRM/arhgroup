<?php

use yii\db\Migration;

/**
 * Handles adding interest to table `payment_type`.
 */
class m170216_065244_add_interest_column_to_payment_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('payment_type', 'interest', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('payment_type', 'interest');
    }
}
