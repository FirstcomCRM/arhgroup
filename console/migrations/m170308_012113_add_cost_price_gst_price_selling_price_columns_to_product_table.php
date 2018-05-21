<?php

use yii\db\Migration;

/**
 * Handles adding cost_price_gst_price_selling_price to table `product`.
 */
class m170308_012113_add_cost_price_gst_price_selling_price_columns_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'cost_price', $this->double(10,2)->notNull());
        $this->addColumn('product', 'gst_price', $this->double(10,2)->notNull());
        $this->addColumn('product', 'selling_price', $this->double(10,2)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('product', 'cost_price');
        $this->dropColumn('product', 'gst_price');
        $this->dropColumn('product', 'selling_price');
    }
}
