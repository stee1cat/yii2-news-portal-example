<?php

use yii\db\Migration;

class m170218_090502_update_user extends Migration
{

    protected $tableName = '{{%user}}';

    public function safeUp()
    {
        $this->renameColumn($this->tableName, 'email_is_confirmed', 'status');
        $this->alterColumn($this->tableName, 'status', $this->integer()->unsigned()->defaultValue(0)->comment('Status'));
    }

    public function safeDown()
    {
        $this->renameColumn($this->tableName, 'status', 'email_is_confirmed');
        $this->alterColumn($this->tableName, 'email_is_confirmed', $this->boolean()->comment('Email Is Confirmed'));
    }

}
