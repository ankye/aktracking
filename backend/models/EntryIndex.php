<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_entry_index}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $from
 * @property integer $toID
 * @property integer $weight
 * @property integer $inactive
 */
class EntryIndex extends \yii\db\ActiveRecord
{
    const LP_2_OFFER = 1;
    const LP_2_LP   = 2;
    const CAMP_2_OFFER = 3;
    const CAMP_2_LP = 4;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_entry_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['toID','weight'], 'required'],
            [['type', 'fromID', 'toID', 'weight', 'inactive'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'type' => Yii::t('tracking', 'Type'),
            'fromID' => Yii::t('tracking', 'From ID'),
            'toID' => Yii::t('tracking', 'To ID'),
            'weight' => Yii::t('tracking', 'Weight'),
            'inactive' => Yii::t('tracking', 'Inactive'),
        ];
    }
}
