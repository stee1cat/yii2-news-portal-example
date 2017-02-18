<?php

namespace app\models;

use app\models\User\Notification;
use app\models\User\Profile;
use app\models\User\UserQuery;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $login
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $password_reset_token
 * @property string $password_hash
 * @property integer $status
 *
 * @property Profile $profile
 * @property Notification[] $notifications
 *
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
    public function rules()
    {
        return [
            [['login'], 'trim'],
            [['login', 'password_hash'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['login', 'password_hash', 'access_token', 'password_reset_token'], 'string', 'max' => 255],
            ['login', 'unique',
                'message' => Yii::t('app', 'User already exists'),
            ],
            [['auth_key'], 'string', 'max' => 32],
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
            'login' => Yii::t('app/models', 'Login'),
            'password' => Yii::t('app/models', 'Password'),
            'auth_key' => Yii::t('app/models', 'Auth Key'),
            'access_token' => Yii::t('app/models', 'Access Token'),
            'password_reset_token' => Yii::t('app/models', 'Password Reset Token'),
            'status' => Yii::t('app/models', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @param integer $userId
     * @return bool
     */
    public function hasId($userId)
    {
        return intval($this->primaryKey) === intval($userId);
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @return ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @param string $login
     * @return User|null
     */
    public static function findByLogin($login)
    {
        return static::findOne([
            'login' => $login,
        ]);
    }

}