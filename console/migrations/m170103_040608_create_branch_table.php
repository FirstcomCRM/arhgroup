<?php

use yii\db\Migration;

/**
 * Handles the creation of table `branch`.
 */
class m170103_040608_create_branch_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('branch', [
            'id' => $this->primaryKey(),
            'code' => $this->string(50)->notNull(),
            'name' => $this->string(50)->notNull(),
            'address' => $this->string(100)->notNull(),
            'contact_no' => $this->string(50)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'updated_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('branch');
    }
}
