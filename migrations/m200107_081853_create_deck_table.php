<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%deck}}`.
 */
class m200107_081853_create_deck_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%deck}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->unique()->notNull(),
            'id_user' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%deck}}');
    }
}
