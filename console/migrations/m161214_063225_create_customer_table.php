<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer`.
 */
class m161214_063225_create_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('customer', [
            'id' => $this->primaryKey(),
            'role' => $this->integer(5)->notNull(),
            'fullname' => $this->string(50)->notNull(),
            'ic' => $this->string(50)->notNull(),
            'password' => $this->string(50)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'auth_key' => $this->string(100)->notNull(),
            'race_id' => $this->integer(5)->notNull(),
            'carplate' => $this->string(50)->notNull(),
            'address' => $this->text()->notNull(),
            'hanphone_no' => $this->string(50)->notNull(),
            'office_no' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull(),
            'make' => $this->string(50)->notNull(),
            'model' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull(),
            'remarks' => $this->text()->notNull(),
            'is_blacklist' => $this->boolean(5)->notNull(),
            'is_member' => $this->string(10)->notNull(),
            'points' => $this->integer(10)->notNull(),
            'member_expiry' => $this->date()->notNull(),
            'status' => $this->boolean(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(10)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(10)->notNull(),
            'deleted' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('customer');
    }
}
