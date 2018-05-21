<?php

use yii\db\Migration;

/**
 * Handles the creation of table `stock_adjustment`.
 */
class m170314_012823_create_stock_adjustment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('stock_adjustment', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(5)->notNull(),
            'old_quantity' => $this->integer(25)->notNull(),
            'new_quantity' => $this->integer(25)->notNull(),
            'datetime_imported' => $this->datetime()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('stock_adjustment');
    }
}
