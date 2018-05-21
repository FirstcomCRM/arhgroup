<?php

use yii\db\Migration;

/**
 * Handles the creation of table `leave_type`.
 */
class m170502_083751_create_leave_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('leave_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'description' => $this->text(),
            'status' => $this->integer(5),
            'created_at' => $this->datetime(),
            'created_by' => $this->integer(5),
            'updated_at' => $this->datetime(),
            'updated_by' => $this->integer(5),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('leave_type');
    }
}
