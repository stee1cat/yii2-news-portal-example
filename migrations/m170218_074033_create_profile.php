<?php

use yii\db\Migration;

class m170218_074033_create_profile extends Migration
{

    protected $tableName = '{{%user_profile}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->integer()->notNull()->comment('User ID'),
            'posts_per_page' => $this->integer()->unsigned()->notNull()->comment('Posts Per Page'),
        ], "CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT 'User Profiles'");

        $this->addForeignKey('profile_to_user', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function safeDown()
    {
        $this->dropForeignKey('profile_to_user', $this->tableName);
        $this->dropTable($this->tableName);

        return true;
    }

}
