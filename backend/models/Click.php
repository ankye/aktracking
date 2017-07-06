<?php

namespace backend\models;

use Yii;
use backend\models\EntryIndex;
use yii\db\Query;

/**
 * This is the model class for table "{{%mts_click}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $campaignID
 * @property integer $type
 * @property integer $fromID
 * @property integer $toID
 * @property integer $channel
 * @property double $cpc
 * @property integer $create_at
 * @property integer $conversion_at
 * @property integer $isconversion
 * @property double $payout
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
 * @property string $IP
 * @property integer $IPINT
 * @property string $countryCode
 * @property string $carrierName
 * @property string $brandName
 * @property string $modelName
 * @property string $deviceOS
 * @property string $osversion
 * @property string $referer
 * @property string $refererDomain
 * @property string $browser
 * @property string $screenResolution
 * @property string $screenSize
 * @property string $deviceType
 * @property string $browserVersion
 * @property string $userAgent
 * @property string $isp
 * @property string $pingbackIP
 * @property integer $pingbackIPINT
 * @property integer $clockID
 * @property string $clockName
 */
class Click extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mts_click}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'campaignID', 'type', 'fromID', 'toID', 'channel',  'isconversion', 'IPINT', 'pingbackIPINT', 'clockID', 'deviceType'], 'integer'],
            [['cpc', 'payout'], 'number'],

            [['c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'IP', 'carrierName', 'brandName', 'modelName', 'deviceOS', 'osversion', 'refererDomain', 'browser', 'screenResolution', 'screenSize', 'browserVersion', 'isp', 'pingbackIP', 'clockName'], 'string', 'max' => 255],
            [['countryCode'], 'string', 'max' => 32],
            [['referer','userAgent'], 'string', 'max' => 1024],

        ];
    }

    public static function getOffers($cid,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);

        $models = (new Query())
            ->select(['campaignID','toID','type','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$cid], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['type','toID'])
            ->orderBy("type desc")
            ->all();
        return $models;
    }

    public static function getCampaignWeekGraph($campaignID,$startTime,$endTime)
    {
        $result = [];
        $weeks =['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        foreach($weeks as $week){

            $result[$week] = ['hour'=>$week,'click'=>0,'lead'=>0,'cost'=>0,'income'=>0,'profit'=>0];

        }
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['DATE_FORMAT(create_at,"%W") as week','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and', ['campaignID'=>$campaignID],['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['DATE_FORMAT(create_at,"%W")'])
            ->all();

        if(isset($models) && is_array($models)){
            foreach($models as $model){
                $result[$model['week']] = $model;
            }
        }
        $out = ['week'=>[],'click'=>[],'lead'=>[],'cost'=>[],'income'=>[],'profit'=>[]];
        $out['week'] = $weeks;
        foreach($weeks as $week){

            $out['click'][] = $result[$week]['click'];
            $out['lead'][] = $result[$week]['lead'];
            $out['cost'][] = Yii::$app->formatter->asDecimal($result[$week]['cost']);
            $out['income'][] = Yii::$app->formatter->asDecimal($result[$week]['income']);
            $out['profit'][] = Yii::$app->formatter->asDecimal($result[$week]['income'] - $result[$week]['cost']);
        }
        return $out;
    }

    public static function getCampaignDayGraph($campaignID,$startTime,$endTime)
    {
        $result = [];
        $hours =[];
        for($i=0;$i<24;$i=$i+1){

            $result[$i] = ['hour'=>$i,'click'=>0,'lead'=>0,'cost'=>0,'income'=>0,'profit'=>0];
            $hours[] = $i;
        }
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['HOUR(create_at) as hour','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and', ['campaignID'=>$campaignID],['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['HOUR(create_at)'])
            ->all();

        if(isset($models) && is_array($models)){
            foreach($models as $model){
                $result[$model['hour']] = $model;
            }
        }
        $out = ['hour'=>[],'click'=>[],'lead'=>[],'cost'=>[],'income'=>[],'profit'=>[]];
        $out['hour'] = $hours;
        for($i=0;$i<24;$i++){

            $out['click'][] = $result[$i]['click'];
            $out['lead'][] = $result[$i]['lead'];
            $out['cost'][] = Yii::$app->formatter->asDecimal($result[$i]['cost']);
            $out['income'][] = Yii::$app->formatter->asDecimal($result[$i]['income']);
            $out['profit'][] = Yii::$app->formatter->asDecimal($result[$i]['income'] - $result[$i]['cost']);
        }
        return $out;
    }

    public static function getGraph($startTime,$endTime)
    {
        $result = [];
        $days =[];
        for($i=$startTime;$i<=$endTime;$i=$i+86400){
            $day = date("Y/m/d",$i);
            $result[$day] = ['day'=>$day,'click'=>0,'lead'=>0,'cost'=>0,'income'=>0,'profit'=>0];
            $days[] = $day;
        }
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['DATE_FORMAT(create_at,"%Y/%m/%d") as day','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and', ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['DATE_FORMAT(create_at,"%Y/%m/%d")'])
            ->all();

        if(isset($models) && is_array($models)){
            foreach($models as $model){
                $result[$model['day']] = $model;
            }
        }
        $out = ['day'=>[],'click'=>[],'lead'=>[],'cost'=>[],'income'=>[],'profit'=>[]];
        $out['day'] = $days;
        $length = count($days);
        for($i=0;$i<$length;$i++){
            $day = $days[$i];
            $out['click'][] = $result[$day]['click'];
            $out['lead'][] = $result[$day]['lead'];
            $out['cost'][] = Yii::$app->formatter->asDecimal($result[$day]['cost']);
            $out['income'][] = Yii::$app->formatter->asDecimal($result[$day]['income']);
            $out['profit'][] = Yii::$app->formatter->asDecimal($result[$day]['income'] - $result[$day]['cost']);
        }
        return $out;
    }

    public static function getCampaignGraph($campaignID,$startTime,$endTime)
    {
        $result = [];
        $days =[];
        for($i=$startTime;$i<=$endTime;$i=$i+86400){
            $day = date("Y/m/d",$i);
            $result[$day] = ['day'=>$day,'click'=>0,'lead'=>0,'cost'=>0,'income'=>0,'profit'=>0];
            $days[] = $day;
        }
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['DATE_FORMAT(create_at,"%Y/%m/%d") as day','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$campaignID], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['DATE_FORMAT(create_at,"%Y/%m/%d")'])
            ->all();

        if(isset($models) && is_array($models)){
            foreach($models as $model){
                $result[$model['day']] = $model;
            }
        }
        $out = ['day'=>[],'click'=>[],'lead'=>[],'cost'=>[],'income'=>[],'profit'=>[]];
        $out['day'] = $days;
        $length = count($days);
        for($i=0;$i<$length;$i++){
            $day = $days[$i];
            $out['click'][] = $result[$day]['click'];
            $out['lead'][] = $result[$day]['lead'];
            $out['cost'][] = Yii::$app->formatter->asDecimal($result[$day]['cost']);
            $out['income'][] = Yii::$app->formatter->asDecimal($result[$day]['income']);
            $out['profit'][] = Yii::$app->formatter->asDecimal($result[$day]['income'] - $result[$day]['cost']);
        }
        return $out;
    }
    public static function getCampaign($campaignID,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['campaignID','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$campaignID], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['campaignID'])
            ->all();
        return $models;
    }
    public static function getCampaigns($startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['campaignID','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and', ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['campaignID'])
            ->all();
        return $models;
    }

    public static function clearClicks($campaignID,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        return Click::deleteAll(['and',['campaignID'=>$campaignID] ,['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime]]);
    }

    public static function updateCpc($campaignID,$cpc,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);

       return Click::updateAll(['cpc'=>$cpc],['and',['campaignID'=>$campaignID] ,['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]]);
    }
    public static function getGroup($groups,$campaignID,$startTime,$endTime){
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $select = ['count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'];


        $models = (new Query())
            ->select(array_merge($select,$groups))
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$campaignID], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy($groups)
            ->all();
        return $models;
    }
    public static function getDayparting($campaignID,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['HOUR(create_at) as hour','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$campaignID], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['HOUR(create_at)'])
            ->all();
        return $models;
    }

    public static function getWeekparting($campaignID,$startTime,$endTime)
    {
        $startTime = date("Y/m/d H:i:s",$startTime);
        $endTime = date("Y/m/d H:i:s",$endTime);
        $models = (new Query())
            ->select(['DATE_FORMAT(create_at,"%W") as week','count(id) as click','sum(cpc) as cost','sum(payout*isconversion) as income','sum(isconversion) as lead'])
            ->from(self::tableName())
            ->where(['and',['campaignID'=>$campaignID], ['<=', 'create_at', $endTime], ['>=', 'create_at', $startTime],['type'=>[EntryIndex::CAMP_2_OFFER,EntryIndex::CAMP_2_LP]]])
            ->groupBy(['DATE_FORMAT(create_at,"%W")'])
            ->all();
        return $models;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('tracking', 'ID'),
            'pid' => Yii::t('tracking', 'Pid'),
            'campaignID' => Yii::t('tracking', 'Campaign ID'),
            'type' => Yii::t('tracking', 'Type'),
            'fromID' => Yii::t('tracking', 'From ID'),
            'toID' => Yii::t('tracking', 'To ID'),
            'channel' => Yii::t('tracking', 'Channel'),
            'cpc' => Yii::t('tracking', 'Cpc'),
            'create_at' => Yii::t('tracking', 'Create At'),
            'conversion_at' => Yii::t('tracking', 'Conversion At'),
            'isconversion' => Yii::t('tracking', 'Isconversion'),
            'payout' => Yii::t('tracking', 'Payout'),
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
            'IP' => Yii::t('tracking', 'Ip'),
            'IPINT' => Yii::t('tracking', 'Ipint'),
            'countryCode' => Yii::t('tracking', 'Country Code'),
            'carrierName' => Yii::t('tracking', 'Carrier Name'),
            'brandName' => Yii::t('tracking', 'Brand Name'),
            'modelName' => Yii::t('tracking', 'Model Name'),
            'deviceOS' => Yii::t('tracking', 'Device Os'),
            'osversion' => Yii::t('tracking', 'Osversion'),
            'referer' => Yii::t('tracking', 'Referer'),
            'refererDomain' => Yii::t('tracking', 'Referer Domain'),
            'browser' => Yii::t('tracking', 'Browser'),
            'screenResolution' => Yii::t('tracking', 'Screen Resolution'),
            'screenSize' => Yii::t('tracking', 'Screen Size'),
            'deviceType' => Yii::t('tracking', 'Device Type'),
            'browserVersion' => Yii::t('tracking', 'Browser Version'),
            'userAgent' => Yii::t('tracking', 'User Agent'),
            'isp' => Yii::t('tracking', 'Isp'),
            'pingbackIP' => Yii::t('tracking', 'Pingback Ip'),
            'pingbackIPINT' => Yii::t('tracking', 'Pingback Ipint'),
            'clockID' => Yii::t('tracking', 'Clock ID'),
            'clockName' => Yii::t('tracking', 'Clock Name'),
        ];
    }
}
