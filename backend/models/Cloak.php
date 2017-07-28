<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%mts_cloak}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $rule
 */
class Cloak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_cloak}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['rule'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
//            $trule = $this->rule;
//
//            if($this->type == 1){
//                $trule['fromint'] =  ip2long($trule['from']);
//                $trule['toint']= ip2long($trule['to']);
//            }else if($this->type == 2){
//                $trule['ipint'] = ip2long($trule['ip']);
//            }
//
//            $this->rule = json_encode($trule);

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
//        $this->rule = json_decode($this->rule,true);

    }


    public static function dropDownItems()
    {
        $cacheKey = 'cloakList';
        $items = Yii::$app->cache->get([$cacheKey]);
        if ($items === false) {
            $query = static::find();

            $list = $query->asArray()->all();
            $items = [];
            foreach ($list as $item){
                $items[$item['id']] = $item['name'];
            }

            Yii::$app->cache->set([$cacheKey], $items, 0);
        }
        return $items;
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(['cloakList']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'name' => Yii::t('tracking', 'Name'),
            'type' => Yii::t('tracking', 'Type'),
            'rule' => Yii::t('tracking', 'Rule'),
        ];
    }
}
