<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models;

use app\models\Notification\Type\TypeQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id ID
 * @property integer $created_at Created At
 * @property integer $updated_at Updated At
 * @property string $event Event
 * @property string $subject Subject
 * @property string $message Message
 * @property string $role Group
 *
 * @property Notification\Type[] $types
 * @property Role $group
 */
class Notification extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
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
            [['event', 'subject'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['event', 'subject'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 32],
            [
                ['role'], 'exist', 'skipOnError' => true,
                'targetClass' => Role::class,
                'targetAttribute' => ['role' => 'name'],
            ],
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
            'event' => Yii::t('app/models', 'Event'),
            'subject' => Yii::t('app/models', 'Subject'),
            'message' => Yii::t('app/models', 'Message'),
            'role' => Yii::t('app/models', 'Group'),
            'types' => Yii::t('app/models', 'Types'),
        ];
    }

    public static function find()
    {
        return new Notification\NotificationQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Role::className(), ['name' => 'role']);
    }

    /**
     * @return TypeQuery|ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Notification\Type::className(), ['notification_id' => 'id']);
    }

}
