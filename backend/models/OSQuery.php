<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[OS]].
 *
 * @see OS
 */
class OSQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OS[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OS|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
