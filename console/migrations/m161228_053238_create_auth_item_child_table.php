<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_item_child`.
 */
class m161228_053238_create_auth_item_child_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item_child', [
            'id' => $this->primaryKey(),
            'parent' => $this->string(50)->notNull(),
            'child' => $this->string(50)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_item_child');
    }
}
