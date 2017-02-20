<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Notification;

use app\models\Notification;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification_type}}".
 *
 * @property integer $id ID
 * @property integer $notification_id Notification ID
 * @property string $type Notification Type
 * @property string $status Status
 *
 * @property Notification $notification
 */
class Type extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_id', 'type'], 'required'],
            [['notification_id', 'status'], 'integer'],
            [['type'], 'string', 'max' => 32],
            [
                ['notification_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Notification::class,
                'targetAttribute' => ['notification_id' => 'id'],
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
            'notification_id' => Yii::t('app/models', 'Notification ID'),
            'type' => Yii::t('app/models', 'Notification Type'),
            'status' => Yii::t('app/models', 'Status'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id' => 'notification_id']);
    }

    /**
     * @inheritdoc
     * @return Type\TypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Type\TypeQuery(get_called_class());
    }

}
