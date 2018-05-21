<?php

use yii\db\Migration;

/**
 * Handles the creation of table `designated_position`.
 */
class m170320_025146_create_designated_position_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('designated_position', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(10)->notNull(),
            'status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('designated_position');
    }
}
