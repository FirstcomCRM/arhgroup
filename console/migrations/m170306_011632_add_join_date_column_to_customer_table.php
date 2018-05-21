<?php

use yii\db\Migration;

/**
 * Handles adding join_date to table `customer`.
 */
class m170306_011632_add_join_date_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'join_date', $this->date()->notNull());
    }   

    public function down()
    {
        $this->dropColumn('customer', 'join_date');
    }
}
