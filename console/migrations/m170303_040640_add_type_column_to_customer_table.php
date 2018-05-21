<?php

use yii\db\Migration;

/**
 * Handles adding type to table `customer`.
 */
class m170303_040640_add_type_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'type', $this->integer(5)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('customer', 'type');
    }
}
