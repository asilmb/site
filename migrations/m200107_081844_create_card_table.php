<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%card}}`.
 */
class m200107_081844_create_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%card}}', [
            'id' => $this->primaryKey(),
            'id_deck' => $this->integer()->notNull(),
            'front'=>$this->string()->notNull(),
            'back'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%card}}');
    }
}
