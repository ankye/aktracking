<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Trafficsource]].
 *
 * @see Trafficsource
 */
class TrafficsourceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Trafficsource[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Trafficsource|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
