<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_continent}}".
 *
 * @property integer $id
 * @property string $continentCode
 * @property string $name
 */
class Continent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_continent}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['continentCode'], 'required'],
            [['continentCode'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 255],
            [['continentCode'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'continentCode' => Yii::t('tracking', 'Continent Code'),
            'name' => Yii::t('tracking', 'Name'),
        ];
    }

    /**
     * @inheritdoc
     * @return ContinentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContinentQuery(get_called_class());
    }
}
