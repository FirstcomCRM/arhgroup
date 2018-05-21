<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gst`.
 */
class m170103_064043_create_gst_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gst', [
            'id' => $this->primaryKey(),
            'gst' => $this->string(10)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gst');
    }
}
