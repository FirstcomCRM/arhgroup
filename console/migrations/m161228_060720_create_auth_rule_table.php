<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auth_rule`.
 */
class m161228_060720_create_auth_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_rule', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'data' => $this->text()->notNull(),
            'created_at' => $this->integer(10)->notNull(),
            'updated_at' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_rule');
    }
}
