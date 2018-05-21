<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_assignment`.
 */
class m161228_053844_create_auth_assignment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_assignment', [
            'id' => $this->primaryKey(),
            'item_name' => $this->string(50)->notNull(),
            'user_id' => $this->string(50)->notNull(),
            'created_at' => $this->integer(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_assignment');
    }
}
