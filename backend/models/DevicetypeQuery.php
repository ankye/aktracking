<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Devicetype]].
 *
 * @see Devicetype
 */
class DevicetypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Devicetype[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Devicetype|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
