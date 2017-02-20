<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Notification\Type;

use app\models\Notification\Type;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Notification\Type]].
 *
 * @see \app\models\Notification\Type
 */
class TypeQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere([
            'status' => TypeStatus::ACTIVE()->getValue(),
        ]);
    }

    /**
     * @inheritdoc
     * @return Type[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Type|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
