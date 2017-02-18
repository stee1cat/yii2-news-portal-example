<?php

namespace app\models\User;

use app\models\Post\PostsPerPage;
use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id ID
 * @property integer $user_id User ID
 * @property string $posts_per_page Posts per page
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['posts_per_page', 'default', 'value' => PostsPerPage::N_10()->getValue()],
            [['user_id'], 'required'],
            [['user_id', 'posts_per_page'], 'integer'],
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
            'id' => Yii::t('app/models', 'ID'),
            'user_id' => Yii::t('app/models', 'User ID'),
            'posts_per_page' => Yii::t('app/models', 'Posts Per Page'),
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
