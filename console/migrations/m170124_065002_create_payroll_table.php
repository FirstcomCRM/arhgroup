<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payroll`.
 */
class m170124_065002_create_payroll_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payroll', [
            'id' => $this->primaryKey(),
            'staff_id' => $this->integer(5)->notNull(),
            'pay_date' => $this->date()->notNull(),
            'overtime_hours' => $this->integer(25)->notNull(),
            'commission' => $this->double(10,2)->notNull(),
            'employees_cpf' => $this->double(10,2)->notNull(),
            'employers_cpf' => $this->double(10,2)->notNull(),
            'sinda' =>$this->double(10,2)->notNull(),
            'advance_loan' => $this->double(10,2)->notNull(),
            'income_tax' => $this->double(10,2)->notNull(),
            'reimbursement' => $this->double(10,2)->notNull(),
            'prepared_by' => $this->string(50)->notNull(),
            'approved_by' => $this->string(50)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payroll');
    }
}
