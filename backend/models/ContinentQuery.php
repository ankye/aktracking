<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Continent]].
 *
 * @see Continent
 */
class ContinentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Continent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Continent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
