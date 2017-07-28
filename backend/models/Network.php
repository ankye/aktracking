<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_network}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $apikey
 * @property string $apiurl
 * @property string $website
 * @property string $systemType
 */
class Network extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_network}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'apikey', 'apiurl', 'website'], 'string', 'max' => 255],
            [['systemType'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    public static function dropDownItems()
    {
        $items = Yii::$app->cache->get(['networkList']);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set(['networkList'], $items, 0);
        }
        return $items;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['networkList']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'name' => Yii::t('tracking', 'Name'),
            'apikey' => Yii::t('tracking', 'Apikey'),
            'apiurl' => Yii::t('tracking', 'Apiurl'),
            'website' => Yii::t('tracking', 'Website'),
            'systemType' => Yii::t('tracking', 'System Type'),
        ];
    }
}
