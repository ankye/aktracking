<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_campaign_cloakrule_index}}".
 *
 * @property integer $campaignID
 * @property integer $cloakID
 * @property integer $priority
 */
class CampaignCloakruleIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_campaign_cloakrule_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaignID', 'cloakID'], 'required'],
            [['campaignID', 'cloakID', 'priority'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaignID' => Yii::t('tracking', 'Campaign ID'),
            'cloakID' => Yii::t('tracking', 'Cloak ID'),
            'priority' => Yii::t('tracking', 'Priority'),
        ];
    }
}
