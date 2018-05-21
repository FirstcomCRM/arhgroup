<?php

use yii\db\Migration;

/**
 * Handles adding reorder_level to table `product`.
 */
class m170308_024708_add_reorder_level_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'reorder_level', $this->integer(10)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('product', 'reorder_level');
    }
}
