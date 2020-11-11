<?php

namespace app\models\queries;

use app\models\BnetUser;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[BnetUser]].
 *
 * @see BnetUser
 */
class BnetUserQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BnetUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BnetUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
