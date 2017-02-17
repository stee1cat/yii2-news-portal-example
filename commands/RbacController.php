<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\commands;

use app\rbac\GroupRule;
use app\rbac\Roles;
use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

/**
 * RBAC console controller
 *
 * Class RbacController
 * @package app\commands
 */
class RbacController extends Controller
{

    public function actionInit($id = null)
    {
        /* @var $authManager DbManager  */
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        // Rules
        $groupRule = new GroupRule();
        $authManager->add($groupRule);

        // Roles
        $guest = $authManager->createRole(Roles::GUEST);
        $guest->description = 'Unauthorized users';
        $guest->ruleName = $groupRule->name;
        $authManager->add($guest);

        $user = $authManager->createRole(Roles::USER);
        $user->description = 'Users';
        $user->ruleName = $groupRule->name;
        $authManager->add($user);
        $authManager->addChild($user, $guest);

        $moderator = $authManager->createRole(Roles::MODERATOR);
        $moderator->description = 'Moderators';
        $moderator->ruleName = $groupRule->name;
        $authManager->add($moderator);
        $authManager->addChild($moderator, $user);

        $admin = $authManager->createRole(Roles::ADMIN);
        $admin->description = 'Admins';
        $admin->ruleName = $groupRule->name;
        $authManager->add($admin);
        $authManager->addChild($admin, $moderator);

        // Superadmin assignments
        if ($id !== null) {
            $authManager->assign($admin, $id);
        }

        return 0;
    }

}