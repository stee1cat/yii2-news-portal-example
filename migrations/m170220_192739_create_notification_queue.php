<?php

use yii\db\Migration;

class m170220_192739_create_notification_queue extends Migration
{

    protected $tableName = '{{%notification_queue}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'created_at' => $this->integer()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->comment('Updated At'),
            'user_id' => $this->integer()->notNull()->comment('User ID'),
            'service' =>$this->string(32)->notNull()->comment('Notification Service'),
            'subject' => $this->string()->notNull()->comment('Subject'),
            'message' => $this->text()->comment('Message'),
            'status' => $this->smallInteger()->comment('Status'),
            'params' => $this->string()->comment('Params'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Notifications Queue'");

        $this->addForeignKey('message_to_user', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function safeDown()
    {
        $this->dropForeignKey('message_to_user', $this->tableName);
        $this->dropTable($this->tableName);

        return true;
    }

}
