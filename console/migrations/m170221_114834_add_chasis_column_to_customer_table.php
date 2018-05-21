<?php

use yii\db\Migration;

/**
 * Handles adding chasis to table `customer`.
 */
class m170221_114834_add_chasis_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'chasis', $this->string(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('customer', 'chasis');
    }
}
