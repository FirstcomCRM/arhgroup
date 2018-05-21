<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invoice`.
 */
class m170111_061422_create_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'quotation_code' => $this->string(50)->notNull(),
            'invoice_no' => $this->string(50)->notNull(),
            'user_id' => $this->integer(10)->notNull(),
            'customer_id' => $this->integer(10)->notNull(),
            'branch_id' => $this->integer(10)->notNull(),
            'date_issue' => $this->date()->notNull(),
            'grand_total' => $this->double(10,2)->notNull(),
            'remarks' => $this->text()->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'updated_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(10)->notNull(),
            'delete' => $this->integer(5)->notNull(),
            'task' => $this->integer(5)->notNull(),
            'paid' => $this->integer(5)->notNull(),
            'paid_type' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'payment_status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('invoice');
    }
}
