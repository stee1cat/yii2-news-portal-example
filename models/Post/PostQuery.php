<?php

namespace app\models\Post;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Post]].
 *
 * @see \app\models\Post
 */
class PostQuery extends ActiveQuery
{

    public function active()
    {
        return $this->andWhere([
            'status' => PostStatus::PUBLISHED()->getValue(),
        ]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Post[]|array
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
