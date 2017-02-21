<?php

use yii\db\Migration;

class m170221_050552_insert_notifications extends Migration
{

    protected $tableName = '{{%notification}}';

    protected $relatedTableName = '{{%notification_type}}';

    public function safeUp()
    {
        $this->insert($this->tableName, [
            'created_at' => time(),
            'updated_at' => time(),
            'event' => 'post.published',
            'subject' => '{login} - Опубликована новая статья: {title}',
            'message' => '<div>{preview_text}</div><div><a href="{url}">Читать далее</div>',
            'role' => 'user',
        ]);

        $notificationId = $this->db->lastInsertID;
        if ($notificationId) {
            $services = ['email', 'browser'];

            foreach ($services as $service) {
                $this->insert($this->relatedTableName, [
                    'notification_id' => $notificationId,
                    'type' => $service,
                    'status' => 1,
                ]);
            }
        }
    }

    public function safeDown()
    {
        $this->truncateTable($this->tableName);
        $this->truncateTable($this->relatedTableName);
    }

}
