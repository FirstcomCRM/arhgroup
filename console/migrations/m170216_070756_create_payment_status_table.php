<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment_status`.
 */
class m170216_070756_create_payment_status_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('payment_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('payment_status');
    }
}
