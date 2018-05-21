<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_level`.
 */
class m170112_071611_create_product_level_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_level', [
            'id' => $this->primaryKey(),
            'minimum_level' => $this->integer(10)->notNull(),
            'critical_level' => $this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_level');
    }
}
