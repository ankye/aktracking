<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_browser}}".
 *
 * @property integer $id
 * @property string $name
 */
class Browser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_browser}}';
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
        $cacheKey = 'browserList';
        $items = Yii::$app->cache->get([$cacheKey]);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set([$cacheKey], $items, 0);
        }
        return $items;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['browserList']);
    }
    /**
     * @inheritdoc
     * @return BrowserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BrowserQuery(get_called_class());
    }
}
