<?php

use yii\db\Migration;

class m170219_162042_notification_type extends Migration
{

    protected $tableName = '{{%notification_type}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'notification_id' => $this->integer()->notNull()->comment('Notification ID'),
            'type' => $this->string(32)->notNull()->comment('Notification Type'),
            'status' => $this->integer()->unsigned()->defaultValue(0)->comment('Status'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Notification Types'");

        $this->addForeignKey('type_to_notification', $this->tableName, 'notification_id', '{{%notification}}', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function safeDown()
    {
        $this->dropForeignKey('type_to_notification', $this->tableName);
        $this->dropTable($this->tableName);

        return true;
    }

}
