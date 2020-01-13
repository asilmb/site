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
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'idx-deck-user_id',
            'deck',
            'user_id'
        );
        $this->addForeignKey(
            'fk-deck-user_id',
            'deck',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-deck-user_id',
            'deck'
        );

        $this->dropIndex(
            'idx-deck-user_id',
            'deck'
        );

        $this->dropTable('{{%deck}}');
    }
}
