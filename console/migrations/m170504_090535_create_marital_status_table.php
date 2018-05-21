<?php

use yii\db\Migration;

/**
 * Handles the creation of table `marital_status`.
 */
class m170504_090535_create_marital_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('marital_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'description' => $this->text(),
            'status' => $this->integer(10),
            'created_at' => $this->datetime(),
            'created_by' => $this->integer(10),
            'updated_at' => $this->datetime(),
            'updated_by' => $this->integer(10),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('marital_status');
    }
}
