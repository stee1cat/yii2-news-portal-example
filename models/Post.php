<?php

namespace app\models;

use app\handlers\Events;
use app\models\Post\PostQuery;
use app\models\Post\PostStatus;
use Yii;
use yii\base\Event;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id ID
 * @property integer $created_at Дата создания
 * @property integer $updated_at Дата изменения
 * @property string $title Заголовок
 * @property string $preview_text Текст превью
 * @property string $detail_text Детальный текст
 * @property integer $status Статус
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['preview_text', 'detail_text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app/models', 'ID'),
            'created_at' => Yii::t('app/models', 'Created At'),
            'updated_at' => Yii::t('app/models', 'Updated At'),
            'title' => Yii::t('app/models', 'Title'),
            'preview_text' => Yii::t('app/models', 'Preview Text'),
            'detail_text' => Yii::t('app/models', 'Detail Text'),
            'status' => Yii::t('app/models', 'Status'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$changedAttributes['status'] && $this->status == PostStatus::PUBLISHED()->getValue()) {
            $this->trigger(Events::POST_PUBLISHED, new Event([
                'sender' => $this,
            ]));
        }
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

}
