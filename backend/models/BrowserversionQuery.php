<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Browserversion]].
 *
 * @see Browserversion
 */
class BrowserversionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Browserversion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Browserversion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
