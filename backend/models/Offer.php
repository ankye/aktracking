<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_offer}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $redirectUrl
 * @property double $payout
 * @property integer $networkID
 * @property integer $clicks
 * @property double $cost
 * @property double $income
 * @property integer $conversion
 * @property integer $active
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_offer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'redirectUrl', 'networkID'], 'required'],
            [['payout', 'cost', 'income'], 'number'],
            [['networkID', 'click', 'lead'], 'integer'],
            [['name', 'redirectUrl'], 'string', 'max' => 255],
        ];
    }

    public static function dropDownItems()
    {
        $items = Yii::$app->cache->get(['offerList']);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set(['offerList'], $items, 0);
        }
        return $items;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'name' => Yii::t('tracking', 'Name'),
            'redirectUrl' => Yii::t('tracking', 'Redirect Url'),
            'payout' => Yii::t('tracking', 'Payout'),
            'networkID' => Yii::t('tracking', 'Network ID'),
            'click' => Yii::t('tracking', 'Clicks'),
            'cost' => Yii::t('tracking', 'Cost'),
            'income' => Yii::t('tracking', 'Income'),
            'lead' => Yii::t('tracking', 'Leads'),

        ];
    }

}
