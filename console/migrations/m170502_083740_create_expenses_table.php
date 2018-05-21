<?php

use yii\db\Migration;

/**
 * Handles the creation of table `expenses`.
 */
class m170502_083740_create_expenses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('expenses', [
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
        $this->dropTable('expenses');
    }
}
