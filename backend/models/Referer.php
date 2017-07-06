<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_referer}}".
 *
 * @property integer $id
 * @property string $name
 */
class Referer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_referer}}';
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

    /**
     * @inheritdoc
     * @return RefererQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RefererQuery(get_called_class());
    }
}
