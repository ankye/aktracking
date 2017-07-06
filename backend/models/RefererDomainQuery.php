<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[RefererDomain]].
 *
 * @see RefererDomain
 */
class RefererDomainQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefererDomain[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefererDomain|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
