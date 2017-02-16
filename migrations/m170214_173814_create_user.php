<?php

use yii\db\Migration;

class m170214_173814_create_user extends Migration
{

    protected $tableName = "{{%user}}";

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id" => $this->primaryKey()->comment('ID'),
            "created_at" => $this->integer()->notNull()->comment('Дата создания'),
            "updated_at" => $this->integer()->notNull()->comment('Дата изменения'),
            "login" => $this->string()->notNull()->comment('Логин'),
            'password_hash' => $this->string()->notNull()->comment('Хэш пароля'),
            'auth_key' => $this->string(32)->comment('Ключ авторизации'),
            'access_token' => $this->string()->comment('Токен'),
            'password_reset_token' => $this->string()->comment('Токен сброса пароля'),
            'email_is_confirmed' => $this->boolean()->comment('Флаг подтверждённого e-mail'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Пользователи'");
        return true;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
        return true;
    }

}