<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_refererdomain}}".
 *
 * @property integer $id
 * @property string $name
 */
class RefererDomain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_refererdomain}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'name' => Yii::t('tracking', 'Name'),
        ];
    }

    public static function dropDownItems()
    {
        $cacheKey = 'refererdomainList';
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
        Yii::$app->cache->delete(['refererdomainList']);
    }
    /**
     * @inheritdoc
     * @return RefererDomainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefererDomainQuery(get_called_class());
    }
}
