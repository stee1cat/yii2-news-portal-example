<?php

namespace app\models\User;

use app\rbac\Roles;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere([
            'status' => UserStatus::ACTIVE()->getValue(),
        ]);
    }

    public function allUsers()
    {
        return $this->join('LEFT JOIN', '{{%user_role}}', 'id = user_id')
            ->andWhere([
                'item_name' => Roles::USER,
            ]);
    }

    /**
     * @inheritdoc
     * @return \app\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
