<?php

namespace backend\models;

use Yii;
use backend\models\Offer;
use backend\models\Landingpage;
use backend\models\Redirect;

/**
 * This is the model class for table "{{%mts_campaign}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sourceID
 * @property integer $type
 * @property double $bid
 * @property integer $active
 * @property string $pingback
 * @property string $slug
 * @property string $c1
 * @property string $c2
 * @property string $c3
 * @property string $c4
 * @property string $c5
 * @property string $c6
 * @property string $c7
 * @property string $c8
 * @property string $c9
 * @property string $c10
 * @property string $c11
 * @property string $c12
 * @property string $c13
 * @property string $c14
 * @property string $c15
 * @property string $c16
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_campaign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sourceID', 'type'], 'required'],
            [['sourceID', 'type', 'inactive','passParams'], 'integer'],
            [['bid'], 'number'],
            [['name', 'pingback', 'slug', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16'], 'string', 'max' => 255],
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
            'sourceID' => Yii::t('tracking', 'Source ID'),
            'type' => Yii::t('tracking', 'Type'),
            'bid' => Yii::t('tracking', 'Bid.$'),
            'inactive' => Yii::t('tracking', 'Inactive'),
            'passParams'=> Yii::t('tracking',"Pass Params"),
            'pingback' => Yii::t('tracking', 'Pingback'),
            'slug' => Yii::t('tracking', 'Slug'),
            'c1' => Yii::t('tracking', 'C1'),
            'c2' => Yii::t('tracking', 'C2'),
            'c3' => Yii::t('tracking', 'C3'),
            'c4' => Yii::t('tracking', 'C4'),
            'c5' => Yii::t('tracking', 'C5'),
            'c6' => Yii::t('tracking', 'C6'),
            'c7' => Yii::t('tracking', 'C7'),
            'c8' => Yii::t('tracking', 'C8'),
            'c9' => Yii::t('tracking', 'C9'),
            'c10' => Yii::t('tracking', 'C10'),
            'c11' => Yii::t('tracking', 'C11'),
            'c12' => Yii::t('tracking', 'C12'),
            'c13' => Yii::t('tracking', 'C13'),
            'c14' => Yii::t('tracking', 'C14'),
            'c15' => Yii::t('tracking', 'C15'),
            'c16' => Yii::t('tracking', 'C16'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->slug == null){
                $this->slug = md5($this->name);
            }
            return true;
        } else {
            return false;
        }
    }

    public static function dropDownItems($sourceID = null)
    {
        $items = Yii::$app->cache->get(['campaignList']);
        if ($items === false) {
            if($sourceID){

                $query = static::find()->where(['sourceID'=>$sourceID]);
            }else{
                $query = static::find();
            }


            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set(['campaignList'], $items, 0);
        }
        return $items;
    }


     public function getOffers()
    {
        return $this->hasMany(EntryIndex::className(), ['fromID' => 'id'])->onCondition(['type' => EntryIndex::CAMP_2_OFFER]);
      
    }
    public function getLps()
    {
        return $this->hasMany(EntryIndexEx::className(), ['fromID' => 'id'])->onCondition(['type' =>EntryIndex::CAMP_2_LP]);

    }
    public function getRedirects()
    {
        return $this->hasMany(Redirect::className(),['campaignID'=>'id']);
    }

    public function getActiveOffers()
    {
        return $this->hasMany(EntryIndex::className(), ['fromID' => 'id'])->onCondition(['inactive' => 0,'type'=>[EntryIndex::CAMP_2_LP,EntryIndex::CAMP_2_OFFER]]);

    }
}
