<?php

use yii\db\Migration;

class m170219_154407_create_notification extends Migration
{

    protected $tableName = '{{%notification}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'created_at' => $this->integer()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->comment('Updated At'),
            'event' => $this->string()->notNull()->comment('Event'),
            'subject' => $this->string()->notNull()->comment('Subject'),
            'message' => $this->text()->comment('Message'),
            'role' => $this->string(32)->comment('Group'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Notifications'");

        return true;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);

        return true;
    }

}
