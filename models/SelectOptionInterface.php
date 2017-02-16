<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models;

/**
 * Interface SelectOptionInterface
 * @package app\models
 */
interface SelectOptionInterface
{

    /**
     * @return array
     */
    public static function getOptions();

}