<?php

use yii\db\Migration;

class m170210_052004_add_tables_to_staff_table extends Migration
{
    public function up()
    {
        $this->addColumn('staff', 'staff_group_id', $this->integer(5)->notNull());
        $this->addColumn('staff', 'email', $this->string(100)->notNull());
        $this->addColumn('staff', 'contact_number', $this->string(50)->notNull());
        $this->addColumn('staff', 'basic', $this->double(10,2)->notNull());
        $this->addColumn('staff', 'ic_no', $this->string(50)->notNull());
        $this->addColumn('staff', 'rate_per_hour', $this->double(10,2)->notNull());
        $this->addColumn('staff', 'allowance', $this->double(10,2)->notNull());
    }

    public function down()
    {
        $this->dropColumn('staff', 'staff_group_id');
        $this->dropColumn('staff', 'email');
        $this->dropColumn('staff', 'contact_number');
        $this->dropColumn('staff', 'basic');
        $this->dropColumn('staff', 'ic_no');
        $this->dropColumn('staff', 'rate_per_hour');
        $this->dropColumn('staff', 'allowance');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
