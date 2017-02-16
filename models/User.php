<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
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
 * @property boolean $email_is_confirmed
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
            [['created_at', 'updated_at'], 'integer'],
            [['login', 'password_hash', 'access_token', 'password_reset_token'], 'string', 'max' => 255],
            ['login', 'unique',
                'message' => Yii::t('app', 'Пользователь с таким именем существует.'),
            ],
            [['auth_key'], 'string', 'max' => 32],
            [['email_is_confirmed'], 'boolean'],
            [['email_is_confirmed'], 'default', 'value' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата изменения'),
            'login' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'auth_key' => Yii::t('app', 'Ключ авторизации'),
            'access_token' => Yii::t('app', 'Токен'),
            'password_reset_token' => Yii::t('app', 'Токен сброса пароля'),
            'email_is_confirmed' => Yii::t('app', 'Флаг подтверждённого e-mail'),
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