<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m161213_060531_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'branch_id' => $this->integer(10)->notNull(),
            'role_id' => $this->integer(10)->notNull(),
            'role' => $this->integer(10)->notNull(),
            'fullname' => $this->string(50)->notNull(),
            'username' => $this->string(50)->notNull(),
            'password' => $this->string(50)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'password_reset_token' => $this->string(100)->notNull(),
            'email' => $this->string(50)->notNull(),
            'photo' => $this->string(50)->notNull(),
            'auth_key' => $this->string(50)->notNull(),
            'status' => $this->boolean(5)->notNull(),
            'login' => $this->datetime()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(10)->notNull(),
            'deleted' => $this->boolean(5)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
