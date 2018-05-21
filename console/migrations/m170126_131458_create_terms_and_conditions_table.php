<?php

use yii\db\Migration;

/**
 * Handles the creation of table `terms_and_conditions`.
 */
class m170126_131458_create_terms_and_conditions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('terms_and_conditions', [
            'id' => $this->primaryKey(),
            'descriptions' => $this->text()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'created_at' => $this->date()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->date()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('terms_and_conditions');
    }
}
