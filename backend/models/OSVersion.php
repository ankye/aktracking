<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_osversion}}".
 *
 * @property integer $id
 * @property string $version
 * @property integer $osID
 */
class OSVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_osversion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['osID'], 'integer'],
            [['version'], 'string', 'max' => 255],
            [['osID', 'version'], 'unique', 'targetAttribute' => ['osID', 'version'], 'message' => 'The combination of Version and Os ID has already been taken.'],
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
            'osID' => Yii::t('tracking', 'Os ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return OSVersionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OSVersionQuery(get_called_class());
    }
}
