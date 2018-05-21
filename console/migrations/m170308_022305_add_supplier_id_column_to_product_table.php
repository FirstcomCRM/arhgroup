<?php

use yii\db\Migration;

/**
 * Handles adding supplier_id to table `product`.
 */
class m170308_022305_add_supplier_id_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'supplier_id', $this->integer(5)->notNull());
    }   

    public function down()
    {
        $this->dropColumn('product', 'supplier_id');
    }
}
