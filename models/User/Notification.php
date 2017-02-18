<?php

namespace app\models\User;

use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_notification}}".
 *
 * @property integer $id ID
 * @property integer $user_id User ID
 * @property string $notification Notification Type
 * @property integer $status Notification Status
 *
 * @property User $user
 */
class Notification extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'notification'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['notification'], 'string', 'max' => 32],
            [
                ['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'notification' => Yii::t('app', 'Notification Type'),
            'status' => Yii::t('app', 'Notification Status'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
