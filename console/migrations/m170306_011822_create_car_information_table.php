<?php

use yii\db\Migration;

/**
 * Handles the creation of table `car_information`.
 */
class m170306_011822_create_car_information_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('car_information', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(5)->notNull(),
            'carplate' => $this->string(50)->notNull(),
            'make' => $this->string(50)->notNull(),
            'model' => $this->string(50)->notNull(),
            'engine_no' => $this->string(50)->notNull(),
            'year_mfg' => $this->string(10)->notNull(),
            'chasis' => $this->string(50)->notNull(),
            'points' => $this->integer(10)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('car_information');
    }
}
