<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_trafficsource}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $costType
 * @property string $c1
 * @property string $c2
 * @property string $c3
 * @property string $c4
 * @property string $c5
 * @property string $c6
 * @property string $c7
 * @property string $c8
 * @property string $c9
 * @property string $c10
 * @property string $c11
 * @property string $c12
 * @property string $c13
 * @property string $c14
 * @property string $c15
 * @property string $c16
 */
class Trafficsource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_trafficsource}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'costType'], 'required'],
            [['name', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16'], 'string', 'max' => 255],
            [['costType'], 'string', 'max' => 32],
            [['name'], 'unique'],
        ];
    }

    public static function dropDownItems()
    {
        $items = Yii::$app->cache->get(['trafficsourceList']);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set(['trafficsourceList'], $items, 0);
        }
        return $items;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['trafficsourceList']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'name' => Yii::t('tracking', 'Name'),
            'costType' => Yii::t('tracking', 'Cost Type'),
            'c1' => Yii::t('tracking', 'C1'),
            'c2' => Yii::t('tracking', 'C2'),
            'c3' => Yii::t('tracking', 'C3'),
            'c4' => Yii::t('tracking', 'C4'),
            'c5' => Yii::t('tracking', 'C5'),
            'c6' => Yii::t('tracking', 'C6'),
            'c7' => Yii::t('tracking', 'C7'),
            'c8' => Yii::t('tracking', 'C8'),
            'c9' => Yii::t('tracking', 'C9'),
            'c10' => Yii::t('tracking', 'C10'),
            'c11' => Yii::t('tracking', 'C11'),
            'c12' => Yii::t('tracking', 'C12'),
            'c13' => Yii::t('tracking', 'C13'),
            'c14' => Yii::t('tracking', 'C14'),
            'c15' => Yii::t('tracking', 'C15'),
            'c16' => Yii::t('tracking', 'C16'),
        ];
    }

    /**
     * @inheritdoc
     * @return TrafficsourceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrafficsourceQuery(get_called_class());
    }
}
