<?php

use yii\db\Migration;

/**
 * Class m170218_075832_create_user_notification
 */
class m170218_075832_create_user_notification extends Migration
{

    protected $tableName = '{{%user_notification}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->integer()->notNull()->comment('User ID'),
            'notification' => $this->string(32)->notNull()->comment('Notification Type'),
            'status' => $this->integer()->defaultValue(0)->comment('Notification Status'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'User Notifications'");

        $this->addForeignKey('notification_to_user', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function safeDown()
    {
        $this->dropForeignKey('notification_to_user', $this->tableName);
        $this->dropTable($this->tableName);

        return true;
    }

}
