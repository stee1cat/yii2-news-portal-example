<?php

/**
 * Copyright (c) 2017 Gennadiy Khatuntsev <e.steelcat@gmail.com>
 */

namespace app\models\Notification;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Notification]].
 *
 * @see \app\models\Notification
 */
class NotificationQuery extends ActiveQuery
{

    public function event($event)
    {
        return $this->andWhere([
            'event' => $event,
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
