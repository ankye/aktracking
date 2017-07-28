<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_carrier}}".
 *
 * @property integer $id
 * @property string $countryCode
 * @property string $name
 */
class Carrier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_carrier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryCode'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 255],
            [['countryCode', 'name'], 'unique', 'targetAttribute' => ['countryCode', 'name'], 'message' => 'The combination of Country Code and Name has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'countryCode' => Yii::t('tracking', 'Country Code'),
            'name' => Yii::t('tracking', 'Name'),
        ];
    }

    public static function dropDownItems()
    {
        $cacheKey = 'carrierList';
        $items = Yii::$app->cache->get([$cacheKey]);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['countryCode']] = $item['countryCode'];
            }

            Yii::$app->cache->set([$cacheKey], $items, 0);
        }
        return $items;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['carrierList']);
    }

    public static function dropDownSubItems($country)
    {

        $query = static::find();
        $list = $query->where(['countryCode' => $country])->select('name')->all();
        $items = [];
        if(!empty($list)) {
            foreach ($list as $item) {
                $items[$item['name']] = $item['name'];
            }
        }

        return $items;
    }
    /**
     * @inheritdoc
     * @return CarrierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarrierQuery(get_called_class());
    }
}
