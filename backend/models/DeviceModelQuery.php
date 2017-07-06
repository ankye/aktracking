<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[DeviceModel]].
 *
 * @see DeviceModel
 */
class DeviceModelQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DeviceModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DeviceModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
