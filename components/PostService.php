<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\components;

use yii\base\Component;

/**
 * Class PostService
 * @package app\components
 */
class PostService extends Component
{

    public $defaultPageSize = 10;

    public $pageSizeInput = 'posts-per-page';

    public function getPageSize()
    {
        $value = $this->defaultPageSize;

        if (isset($_COOKIE[$this->pageSizeInput]) && (int) $_COOKIE[$this->pageSizeInput]) {
            $value = $_COOKIE[$this->pageSizeInput];
        }

        return $value;
    }

}