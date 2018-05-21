<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cpf`.
 */
class m170502_083727_create_cpf_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cpf', [
            'id' => $this->primaryKey(),
            'from_age' => $this->integer(10),
            'to_age' => $this->integer(10),
            'employee_cpf' => $this->integer(10),
            'employer_cpf' => $this->integer(10),
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
        $this->dropTable('cpf');
    }
}
