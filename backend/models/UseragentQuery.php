<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Useragent]].
 *
 * @see Useragent
 */
class UseragentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Useragent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Useragent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
