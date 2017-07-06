<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_campingn_landingpage_index}}".
 *
 * @property integer $campaignID
 * @property integer $lpID
 * @property integer $weight
 */
class CampingnLandingpageIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_campingn_landingpage_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaignID', 'lpID', 'weight'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaignID' => Yii::t('tracking', 'Campaign ID'),
            'lpID' => Yii::t('tracking', 'Lp ID'),
            'weight' => Yii::t('tracking', 'Weight'),
        ];
    }
}
