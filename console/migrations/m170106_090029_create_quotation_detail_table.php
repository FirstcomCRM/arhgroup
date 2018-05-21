<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation_detail`.
 */
class m170106_090029_create_quotation_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quotation_detail', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(10)->notNull(),
            'service_part_id' => $this->integer(10)->notNull(),
            'quantity' => $this->integer(10)->notNull(),
            'selling_price' => $this->double(10,2)->notNull(),
            'subTotal' => $this->double(10,2)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'task' => $this->integer(5)->notNull(),
            'invoice' => $this->integer(5)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quotation_detail');
    }
}
