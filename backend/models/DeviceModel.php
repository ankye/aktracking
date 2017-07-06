<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_model}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $brandID
 */
class DeviceModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_model}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandID'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['brandID', 'name'], 'unique', 'targetAttribute' => ['brandID', 'name'], 'message' => 'The combination of Name and Brand ID has already been taken.'],
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
            'brandID' => Yii::t('tracking', 'Brand ID'),
        ];
    }

    public static function dropDownSubItems($brandID)
    {

        $query = static::find();
        $list = $query->where(['brandID' => $brandID])->select('name')->all();
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
     * @return DeviceModelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeviceModelQuery(get_called_class());
    }
}
