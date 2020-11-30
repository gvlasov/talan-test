<?php

use yii\db\Migration;

class m201130_172500_chats extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'chat_id' => $this->integer()->notNull(),
            'text' => $this->string(1024)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->null(),
        ]);
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(1024)->notNull(),
            'created_by_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->null(),
        ]);
        $this->createTable('{{%chat_user}}', [
            'chat_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey(
            'fk_chat_user_chat__participation',
            'chat_user',
            'chat_id',
            'chat',
            'id'
        );
        $this->addForeignKey(
            'fk_chat_user_user__participation',
            'chat_user',
            'user_id',
            'user',
            'id'
        );
        $this->addPrimaryKey(
            'pk_participation',
            'chat_user',
            ['chat_id', 'user_id']
        );
        $this->addForeignKey(
            'fk_chat_user__creator',
            'chat',
            'created_by_id',
            'user',
            'id'
        );
        $this->addForeignKey(
            'fk_message_user__author',
            'message',
            'user_id',
            'user',
            'id'
        );
        $this->addForeignKey(
            'fk_message_chat__destination',
            'message',
            'chat_id',
            'chat',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('message');
        $this->dropTable('chat');
        $this->dropTable('chat_user');
    }

}
