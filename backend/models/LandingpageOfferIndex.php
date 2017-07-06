<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_landingpage_offer_index}}".
 *
 * @property integer $lpID
 * @property integer $offerID
 * @property integer $weight
 */
class LandingpageOfferIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_landingpage_offer_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lpID', 'offerID'], 'required'],
            [['lpID', 'offerID', 'weight'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lpID' => Yii::t('tracking', 'Lp ID'),
            'offerID' => Yii::t('tracking', 'Offer ID'),
            'weight' => Yii::t('tracking', 'Weight'),
        ];
    }
}
