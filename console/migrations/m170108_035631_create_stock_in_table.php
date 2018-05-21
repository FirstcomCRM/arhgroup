<?php

use yii\db\Migration;

/**
 * Handles the creation of table `stock_in`.
 */
class m170108_035631_create_stock_in_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('stock_in', [
            'id' => $this->primaryKey(),
            'product_id' =>$this->integer(5)->notNull(),
            'supplier_id' =>$this->integer(5)->notNull(),
            'quantity' => $this->integer(50)->notNull(),
            'cost_price' => $this->double(10,2)->notNull(),
            'selling_price' => $this->double(10,2)->notNull(),
            'date_imported' => $this->date()->notNull(),
            'time_imported' => $this->date()->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('stock_in');
    }
}
