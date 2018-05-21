<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invoice_detail`.
 */
class m170111_063217_create_invoice_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('invoice_detail', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(10)->notNull(),
            'service_part_id' => $this->integer(10)->notNull(),
            'quantity' => $this->integer(10)->notNull(),
            'selling_price' => $this->double(10,2)->notNull(),
            'subTotal' => $this->double(10,2)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'task' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('invoice_detail');
    }
}
