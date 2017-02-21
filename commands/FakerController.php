<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <hg@kamchatka-perm.ru>
 */

namespace app\commands;

use app\models\Post;
use app\models\User;
use app\rbac\Roles;
use Faker\Factory;
use Yii;
use yii\console\Controller;

/**
 * Class FakerController
 * @package app\commands
 */
class FakerController extends Controller
{

    public function actionGenerate()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $user = Yii::$app->userService->create($faker->email, $faker->password(), Roles::USER);
            if ($user) {
                $user->status = User\UserStatus::ACTIVE()->getValue();
                $user->save();
            }
        }

        for ($i = 0; $i < 25; $i++) {
            $post = new Post([
                'title' => $faker->sentence(),
                'preview_text' => $faker->text,
                'detail_text' => $faker->text,
                'status' => Post\PostStatus::PUBLISHED()->getValue(),
            ]);
            $post->save();
        }
    }

}