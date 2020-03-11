<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card}}`.
 */
class m200111_111158_create_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card}}', [
            'id' => $this->primaryKey(),
            'deck_id' => $this->integer()->notNull(),
            'front' => $this->string()->notNull(),
            'back' => $this->string()->notNull(),
            'image' => $this->string(),
            'view_count'=>$this->integer()->defaultValue(0),
            'success_count' => $this->integer()->defaultValue(0),
            'hidden' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex(
            'idx-card-deck_id',
            'card',
            'deck_id'
        );

        $this->addForeignKey(
            'fk-card-deck_id',
            'card',
            'deck_id',
            'deck',
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
            'fk-card-deck_id',
            'card'
        );

        $this->dropIndex(
            'idx-card-deck_id',
            'card'
        );
        $this->dropTable('{{%card}}');
    }
}
