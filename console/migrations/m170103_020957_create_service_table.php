<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m170103_020957_create_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'service_category_id' => $this->integer(10)->notNull(),
            'service_name' => $this->string(50)->notNull(),
            'description' => $this->text()->notNull(),
            'default_price' => $this->double(10,2)->notNull(),
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
        $this->dropTable('service');
    }
}
