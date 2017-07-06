<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_campingn_offer_index}}".
 *
 * @property integer $campaignID
 * @property integer $offerID
 * @property integer $weight
 */
class CampingnOfferIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_campingn_offer_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaignID', 'offerID', 'weight'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaignID' => Yii::t('tracking', 'Campaign ID'),
            'offerID' => Yii::t('tracking', 'Offer ID'),
            'weight' => Yii::t('tracking', 'Weight'),
        ];
    }
}
