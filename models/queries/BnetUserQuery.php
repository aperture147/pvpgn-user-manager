<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BnetUser]].
 *
 * @see BnetUser
 */
class BnetUserQuery extends \yii\db\ActiveQuery
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
