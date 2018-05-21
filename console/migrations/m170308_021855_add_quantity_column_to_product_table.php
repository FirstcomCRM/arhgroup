<?php

use yii\db\Migration;

/**
 * Handles adding quantity to table `product`.
 */
class m170308_021855_add_quantity_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'quantity', $this->integer(50)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('product', 'quantity');
    }
}
