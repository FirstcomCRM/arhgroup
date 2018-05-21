<?php

use yii\db\Migration;

/**
 * Handles the creation of table `staff`.
 */
class m170124_054358_create_staff_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('staff', [
            'id' => $this->primaryKey(),
            'staff_code' => $this->string(50)->notNull(),
            'fullname' => $this->string(100)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(5)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('staff');
    }
}
