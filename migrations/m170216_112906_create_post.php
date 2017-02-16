<?php

use yii\db\Migration;

class m170216_112906_create_post extends Migration
{

    protected $tableName = "{{%post}}";

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id" => $this->primaryKey()->comment('ID'),
            "created_at" => $this->integer()->notNull()->comment('Дата создания'),
            "updated_at" => $this->integer()->notNull()->comment('Дата изменения'),
            "title" => $this->string()->notNull()->comment('Заголовок'),
            'preview_text' => $this->text()->comment('Текст превью'),
            'detail_text' => $this->text()->comment('Детальный текст'),
            'status' => $this->smallInteger()->comment('Статус'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Статьи'");

        return true;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);

        return true;
    }

}
