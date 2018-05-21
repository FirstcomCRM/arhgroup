<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_permission`.
 */
class m161228_021117_create_user_permission_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_permission', [
            'id' => $this->primaryKey(),
            'controller' => $this->string(50)->notNull(),
            'action' => $this->string(50)->notNull(),
            'role_id' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_permission');
    }
}
