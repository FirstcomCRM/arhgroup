<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_item`.
 */
class m161228_054548_create_auth_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'type' => $this->integer(10)->notNull(),
            'description' => $this->text()->notNull(),
            'rule_name' => $this->string(50)->notNull(),
            'data' => $this->text()->notNull(),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_item');
    }
}
