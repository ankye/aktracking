<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_country}}".
 *
 * @property integer $id
 * @property string $countryCode
 * @property string $name
 * @property integer $continentID
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryCode', 'continentID'], 'required'],
            [['continentID'], 'integer'],
            [['countryCode'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 255],
            [['continentID', 'countryCode'], 'unique', 'targetAttribute' => ['continentID', 'countryCode'], 'message' => 'The combination of Country Code and Continent ID has already been taken.'],
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
            'continentID' => Yii::t('tracking', 'Continent ID'),
        ];
    }

    public static function dropDownItems()
    {
        $cacheKey = 'countryList';
        $items = Yii::$app->cache->get([$cacheKey]);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['countryCode'];
            }

            Yii::$app->cache->set([$cacheKey], $items, 0);
        }
        return $items;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['countryList']);
    }
    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
