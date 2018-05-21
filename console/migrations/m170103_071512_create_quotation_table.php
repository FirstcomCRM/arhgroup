<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation`.
 */
class m170103_071512_create_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quotation', [
            'id' => $this->primaryKey(),
            'quotation_code' => $this->string(50)->notNull(),
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
            'invoice' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quotation');
    }
}
