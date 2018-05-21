<?php

use yii\db\Migration;

/**
 * Handles the creation of table `module_access`.
 */
class m170108_133828_create_module_access_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('module_access', [
            'id' => $this->primaryKey(),
            'modules_id' => $this->string(50)->notNull(),
            'role_id' => $this->string(50)->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'created_at' => $this->date()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('module_access');
    }
}
