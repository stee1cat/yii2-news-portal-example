<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use app\models\User\Profile;
use Yii;
use yii\base\Component;

/**
 * Class PostService
 * @package app\components
 */
class PostService extends Component
{

    public $defaultPageSize = 10;

    public function getPageSize()
    {
        $value = $this->defaultPageSize;

        if (($profile = $this->getUserProfile()) && $profile->posts_per_page) {
            $value = $profile->posts_per_page;
        }

        return $value;
    }

    /**
     * @return Profile|null/boolean
     */
    protected function getUserProfile()
    {
        return Yii::$app->user->identity ? Yii::$app->user->identity->profile : false;
    }

}