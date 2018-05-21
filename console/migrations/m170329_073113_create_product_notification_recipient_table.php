<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_email_recipient`.
 */
class m170329_073113_create_product_notification_recipient_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // $this->createTable('product_notification_recipient', [
        //     'id' => $this->primaryKey(),
        //     'email' => $this->string(50)->notNull(),
        //     'created_at' => $this->datetime()->notNull(),
        //     'created_by' => $this->integer(10)->notNull(),
        //     'updated_at' => $this->datetime()->notNull(),
        //     'updated_by' => $this->integer(10)->notNull(),
        //     'status' => $this->integer(5)->notNull(),
        // ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_notification_recipient');
    }
}
