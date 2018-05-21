<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m161220_090021_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(50)->notNull(),
            'product_name' => $this->string(50)->notNull(),
            'product_image' => $this->string(50)->notNull(),
            'unit_of_measure' => $this->string(50)->notNull(),
            'status' => $this->boolean(5)->notNull(),
            'category_id' => $this->integer(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
