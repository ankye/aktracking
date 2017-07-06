<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Brand]].
 *
 * @see Brand
 */
class BrandQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Brand[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Brand|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
