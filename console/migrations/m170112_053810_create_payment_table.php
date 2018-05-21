<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m170112_053810_create_payment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer(5)->notNull(),
            'invoice_no' => $this->string(10)->notNull(),
            'customer_id' => $this->integer(5)->notNull(),
            'amount' => $this->double(10,2)->notNull(),
            'discount' => $this->double(10,2)->notNull(),
            'payment_method' => $this->integer(5)->notNull(),
            'payment_type' => $this->string(50)->notNull(),
            'points_earned' => $this->integer(5)->notNull(),
            'points_redeem' => $this->integer(5)->notNull(),
            'remarks' => $this->text()->notNull(),
            'payment_date' => $this->date()->notNull(),
            'payment_time' => $this->time()->notNull(),
            'status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment');
    }
}
