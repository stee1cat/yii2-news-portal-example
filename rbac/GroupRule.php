<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Class GroupRule
 * @package app\rbac
 */
class GroupRule extends Rule
{

    /**
     * @inheritdoc
     */
    public $name = 'group';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $result = false;

        if (!Yii::$app->user->isGuest) {
            $roles = Yii::$app->authManager->getRolesByUser($user);

            if ($item->name === Roles::ADMIN) {
                $result = isset($roles[$item->name]);
            }
            else if ($item->name === Roles::MODERATOR) {
                $result = isset($roles[$item->name]) || isset($roles[Roles::ADMIN]) ;
            }
            else if ($item->name === Roles::USER) {
                $result = isset($roles[$item->name]) || isset($roles[Roles::ADMIN]) || isset($roles[Roles::MODERATOR]);
            }
            else if ($item->name === Roles::GUEST) {
                $result = isset($roles[$item->name]) || isset($roles[Roles::ADMIN]) || isset($roles[Roles::MODERATOR]) || isset($roles[Roles::USER]);
            }

        }

        return $result;
    }

}