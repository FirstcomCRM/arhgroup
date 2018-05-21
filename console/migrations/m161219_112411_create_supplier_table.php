<?php

use yii\db\Migration;

/**
 * Handles the creation of table `supplier`.
 */
class m161219_112411_create_supplier_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('supplier', [
            'id' => $this->primaryKey(),
            'supplier_code' => $this->string(50)->notNull(),
            'supplier_name' => $this->string(50)->notNull(),
            'address' => $this->text()->notNull(),
            'contact_number' => $this->string(50)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('supplier');
    }
}
