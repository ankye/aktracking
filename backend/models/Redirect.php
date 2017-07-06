<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_redirect}}".
 *
 * @property integer $id
 * @property integer $campaignID
 * @property integer $redirectType
 * @property string $type
 * @property string $subtype
 * @property integer $opt
 * @property string $optValue
 * @property integer $priority
 * @property string $redirectUrl
 */
class Redirect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_redirect}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'redirectType', 'type', 'opt', 'redirectUrl','priority'], 'required'],
            [['campaignID', 'redirectType', 'opt', 'priority'], 'integer'],
            [['type', 'subtype', 'redirectUrl'], 'string', 'max' => 255],
            [['optValue'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'campaignID' => Yii::t('tracking', 'Campaign ID'),
            'redirectType' => Yii::t('tracking', 'Redirect Type'),
            'type' => Yii::t('tracking', 'Type'),
            'subtype' => Yii::t('tracking', 'Subtype'),
            'opt' => Yii::t('tracking', 'Opt'),
            'optValue' => Yii::t('tracking', 'Opt Value'),
            'priority' => Yii::t('tracking', 'Priority'),
            'redirectUrl' => Yii::t('tracking', 'Redirect Url'),
        ];
    }



    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaignID']);
    }
}
