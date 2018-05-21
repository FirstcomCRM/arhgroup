<?php

use yii\db\Migration;

/**
 * Handles the creation of table `inventory`.
 */
class m161221_094318_create_inventory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('inventory', [
            'id' => $this->primaryKey(),
            'product_id' =>$this->integer(5)->notNull(),
            'supplier_id' =>$this->integer(5)->notNull(),
            'quantity' => $this->integer(50)->notNull(),
            'cost_price' => $this->double(10,2)->notNull(),
            'selling_price' => $this->double(10,2)->notNull(),
            'date_imported' => $this->date()->notNull(),
            'status' => $this->boolean(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('inventory');
    }
}
