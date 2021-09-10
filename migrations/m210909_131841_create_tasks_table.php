<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m210909_131841_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->text()->notNull(),
            'file' => $this->string(),
            'created_at'  => $this->integer()->notNull(),
            'updated_at'  =>$this->integer()->null(),
        ]);

        $this->createIndex('{{%idx-tasks-user_id}}', '{{%tasks}}', 'user_id');
        $this->addForeignKey('{{%fk-tasks-user_id}}', '{{%tasks}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }
}
