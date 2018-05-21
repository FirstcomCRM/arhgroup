<?php

use yii\db\Migration;

/**
 * Handles adding company_name_and_uen_no to table `customer`.
 */
class m170303_034434_add_company_name_and_uen_no_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'company_name', $this->string(100)->notNull());
        $this->addColumn('customer', 'uen_no', $this->string(100)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('customer', 'company_name');
        $this->dropColumn('customer', 'uen_no');
    }
}
