<?php

use yii\db\Migration;

/**
 * Handles the creation of table `modules`.
 */
class m161216_114047_create_modules_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('modules', [
            'id' => $this->primaryKey(),
            'modules' => $this->string(50)->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('modules');
    }
}
