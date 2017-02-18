<?php

use yii\db\Migration;

class m170216_112906_create_post extends Migration
{

    protected $tableName = "{{%post}}";

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'created_at' => $this->integer()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->notNull()->comment('Updated At'),
            'title' => $this->string()->notNull()->comment('Title'),
            'preview_text' => $this->text()->comment('Preview Text'),
            'detail_text' => $this->text()->comment('Detail Text'),
            'status' => $this->smallInteger()->comment('Status'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'Posts'");

        return true;
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);

        return true;
    }

}
