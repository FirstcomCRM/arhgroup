<?php

use yii\db\Migration;

/**
 * Handles adding mileage to table `quotation`.
 */
class m170215_023956_add_mileage_column_to_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'mileage', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('quotation', 'mileage');
    }
}
