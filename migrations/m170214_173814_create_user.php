<?php

use yii\db\Migration;

class m170214_173814_create_user extends Migration
{

    protected $tableName = '{{%user}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'created_at' => $this->integer()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->comment('Updated At'),
            'login' => $this->string()->notNull()->comment('Login'),
            'password_hash' => $this->string()->notNull()->comment('Password Hash'),
            'auth_key' => $this->string(32)->comment('Auth Key'),
            'access_token' => $this->string()->comment('Access Token'),
            'password_reset_token' => $this->string()->comment('Password Reset Token'),
            'email_is_confirmed' => $this->boolean()->comment('Email Is Confirmed'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Users'");

        return true;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);

        return true;
    }

}