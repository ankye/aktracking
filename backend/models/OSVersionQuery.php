<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[OSVersion]].
 *
 * @see OSVersion
 */
class OSVersionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OSVersion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OSVersion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
