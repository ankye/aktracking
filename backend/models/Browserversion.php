<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_browserversion}}".
 *
 * @property integer $id
 * @property string $version
 * @property integer $browserID
 */
class Browserversion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_browserversion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['browserID'], 'integer'],
            [['version'], 'string', 'max' => 255],
            [['browserID', 'version'], 'unique', 'targetAttribute' => ['browserID', 'version'], 'message' => 'The combination of Version and Browser ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'version' => Yii::t('tracking', 'Version'),
            'browserID' => Yii::t('tracking', 'Browser ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return BrowserversionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BrowserversionQuery(get_called_class());
    }
}
