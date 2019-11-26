<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mail}}`.
 */
class m191125_122403_create_mail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mail}}', [
           'mail' => $this->char(255)->notNull()->unique(),
            'hash' => $this->char(255)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail}}');
    }
}
