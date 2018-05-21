<?php

use yii\db\Migration;

/**
 * Handles the creation of table `claims_type`.
 */
class m170502_083715_create_claims_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('claims_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'description' => $this->text(),
            'amount' => $this->double(10,2),
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
        $this->dropTable('claims_type');
    }
}
