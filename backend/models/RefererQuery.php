<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Referer]].
 *
 * @see Referer
 */
class RefererQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Referer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Referer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
