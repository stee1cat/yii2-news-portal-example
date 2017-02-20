<?php

namespace app\models\Notification;

use app\models\User;
use app\models\User\UserQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%notification_queue}}".
 *
 * @property integer $id ID
 * @property integer $created_at Created At
 * @property integer $updated_at Updated At
 * @property integer $user_id User ID
 * @property string $service Notification Service
 * @property string $subject Subject
 * @property string $message Message
 * @property integer $status Status
 * @property string $params Params
 */
class Message extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification_queue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'service', 'subject'], 'required'],
            [['created_at', 'updated_at', 'user_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['service'], 'string', 'max' => 32],
            [['subject', 'params'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
            'user_id' => Yii::t('app/models', 'User ID'),
            'service' => Yii::t('app/models', 'Notification Service'),
            'subject' => Yii::t('app/models', 'Subject'),
            'message' => Yii::t('app/models', 'Message'),
            'status' => Yii::t('app/models', 'Status'),
            'params' => Yii::t('app/models', 'Params'),
        ];
    }

    /**
     * @return ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
