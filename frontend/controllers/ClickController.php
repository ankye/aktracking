<?php

namespace frontend\controllers;

use backend\models\Campaign;
use common\helpers\Util;
use Yii;
use backend\models\Click;
use backend\models\Offer;
use backend\models\Landingpage;
use backend\models\EntryIndex;
use backend\models\Cloak;
use common\helpers\RedirectUtil;

class ClickController extends \yii\web\Controller
{
    //landingpage -> offer
    //landingpage -> landingpage
    public function actionIndex()
    {

        $out = Yii::$app->request->get("out");
        if(!$out){
            echo Yii::t("tracking","error params");
            exit;
        }
        $params = \GuzzleHttp\json_decode(base64_decode($out),true);

        $pid =  $params['pid'];
        $pClick = Click::findOne(['id'=>$pid]);
        $lpID = $pClick->toID;
        $lp = Landingpage::findOne(["id"=>$lpID]);

        $click = new Click;
        $click->pid = $pClick->id;
        $click->campaignID = $pClick->campaignID;
        $click->cpc = 0;
        $click->create_at = date("Y/m/d H:i:s");
        $click->fromID = $pClick->toID;
        //collect device data
        $click->IP = $pClick->IP;
        $click->IPINT = $pClick->IPINT;
        $click->countryCode = $pClick->countryCode;
        $click->isp = $pClick->isp;
        $click->carrierName = $pClick->carrierName;
        $click->userAgent = Util::getUserAgent();
        $click->deviceType = $pClick->deviceType;
        $click->referer = "";
        $click->refererDomain = "";
        if(isset($_SERVER['HTTP_REFERER'])){
            $referer_url_parsed = @parse_url($_SERVER['HTTP_REFERER']);
            $click->refererDomain = isset($referer_url_parsed['host'])?$referer_url_parsed['host']:"";
            $click->referer = $_SERVER['HTTP_REFERER'];
        }

        for($i=1;$i<=16;$i++){
            $key = "c".$i;
            $value = Yii::$app->request->get($key);
            if($value){
                $click->setAttribute($key,urlencode($value));
            }

        }

        switch ($click->deviceType){
            case 1://desktop
            {

                $click->deviceOS = $pClick->deviceOS;
                $click->osversion = $pClick->osversion;
                $click->browser = $pClick->browser;
                $click->browserVersion = $pClick->browserVersion;


                break;
            }
            case 2: //mobile phone
            case 3: //Tablet
            {

                $click->brandName = $pClick->brandName;
                $click->modelName = $pClick->modelName;
                $click->screenResolution = $pClick->screenResolution;
                $click->deviceOS = $pClick->deviceOS;
                $click->osversion = $pClick->osversion;
                $click->browser = $pClick->browser;
                $click->browserVersion = $pClick->browserVersion;
                $click->screenSize = $pClick->screenSize;

                break;
            }
            case 4: //robot
            {

            }

        }

        $channel = Yii::$app->request->get("channel");
        if($channel){
            $click->channel = $channel;
        }

        //check lp or offer
        $indexs = $lp->activeOffers;

        //rand choose offer
        $offerIndex = $this->randOffer($indexs);



        if($offerIndex->type == EntryIndex::LP_2_OFFER){
            $click->type = EntryIndex::LP_2_OFFER;
            $click->toID = $offerIndex->toID;
            $offer = Offer::findOne(['id'=>$click->toID]);
            $click->payout = $offer->payout;
            $redirect = $offer->redirectUrl;
            if($click->validate()) {
                $click->save(false);
                $redirect = str_replace("{aff_sub}",$click->id,$redirect);

                $this->go($redirect);
            }else{
                var_dump($click->getErrors());
                echo \Yii::t("tracking","Click Offer Model Save Failed");
            }
        }else{
            $click->type = EntryIndex::LP_2_LP;
            $click->toID = $offerIndex->toID;
            $lp = Landingpage::findOne(['id'=>$click->toID]);
            $redirect = $lp->redirectUrl;
            if($click->validate()) {
                $click->save(false);
                $out = [];
                $out['pid'] = $click->id;
                $out["os"] = $click->deviceOS;
                $out["countryCode"] = $click->countryCode;
                $out["brand"] = $click->brandName;
                $out["model"] = $click->modelName;


                $this->go($redirect,$out);
            }else{
                var_dump($click->getErrors());
                echo \Yii::t("tracking","Click LP Model Save Failed");
            }
        }



    }

    /**
    * 二维数组根据字段进行排序
    * @params array $array 需要排序的数组
    * @params string $field 排序的字段
    * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
    */
    function arraySequence($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }
    //campaign -> offer
    //campaign -> landingpage
    public function actionSlug($slug)
    {

        $deviceDetect = Yii::$app->deviceDetect;
        $geoipDetect = Yii::$app->geoipDetect;


        $campaign =  Campaign::findOne(["slug"=>$slug]);
//        var_dump($campaign->offers);

        $click = new Click;


        //campaign info
        $click->campaignID = $campaign->id;
        $click->cpc = $campaign->bid;
        $click->create_at = date("Y/m/d H:i:s");
        $click->fromID = $campaign->id;
        //collect device data
        $click->IP = Util::getIP();
        $click->IPINT = ip2long($click->IP);
        $click->countryCode = $geoipDetect->getCountryCode($click->IP);
        $click->isp = $geoipDetect->getISP($click->IP);
        $click->carrierName = $click->isp;
        $click->userAgent = Util::getUserAgent();
        $click->deviceType = $deviceDetect->devideType($click->userAgent);
        $click->referer = "";
        $click->refererDomain = "";
        if(isset($_SERVER['HTTP_REFERER'])){
            $referer_url_parsed = @parse_url($_SERVER['HTTP_REFERER']);
            $click->refererDomain = isset($referer_url_parsed['host'])?$referer_url_parsed['host']:"";
            $click->referer = $_SERVER['HTTP_REFERER'];
        }

        for($i=1;$i<=16;$i++){
            $key = "c".$i;
            $value = Yii::$app->request->get($key);
            if($value){
                $click->setAttribute($key,urlencode($value));
            }

        }

        switch ($click->deviceType){
            case 1://desktop
            {

                $click->deviceOS = $deviceDetect->platform();
                $click->osversion = $deviceDetect->version($click->deviceOS);
                $click->browser = $deviceDetect->browser();
                $click->browserVersion = $deviceDetect->version($click->browser);


                break;
            }
            case 2: //mobile phone
            case 3: //Tablet
            {
                $mobileDetect = Yii::$app->mobileDetect;
                $mobileData = $mobileDetect->getMobile();
                $click->brandName = $mobileData["brand_name"];
                $click->modelName = $mobileData["model_name"];
                $click->screenResolution = $mobileData["resolution"];
                $click->deviceOS = $mobileData["device_os"];
                $click->osversion = $mobileData["device_os_version"];
                $click->browser = $mobileData["browser"];
                $click->browserVersion = $mobileData["browser_version"];
                $click->screenSize = $mobileData["screen_size"];

                break;
            }
            case 4: //robot
            {

            }

        }

        //check redirect
        $rds = $campaign->redirects;
        
        $rd_url = "";
        $rd_id = 0;
        $rd_name = "";
        $hit_result = null; //flag to hit cloak
        if(isset($rds) && count($rds)>0){
            //begin check redirect


            foreach($rds as $rd){
                $hit_result = RedirectUtil::processHitTest($click,$rd);
                if($hit_result != null){
                    if($hit_result[0]){
                        break;
                    }
                }
            }

            //end check redirect
        }

        if(isset($hit_result) && is_array($hit_result) && count($hit_result)>=4 && $hit_result[0] == true ){
            $rd_id = $hit_result[1];
            $rd_name = $hit_result[2];
            $rd_url = $hit_result[3];
        }


        //check lp or offer
        $indexs = $campaign->activeOffers;

        //rand choose offer
        $offerIndex = $this->randOffer($indexs);


        
        if($offerIndex->type == EntryIndex::CAMP_2_OFFER){
            $click->type = EntryIndex::CAMP_2_OFFER;
            $click->toID = $offerIndex->toID;
            $offer = Offer::findOne(['id'=>$click->toID]);
            $click->payout = $offer->payout;
            $redirect = $offer->redirectUrl;
            if($rd_url != ""){
                $click->clockID = $rd_id;
                $click->clockName = $rd_name;
            }

            if($click->validate()) {
                $click->save(false);
                if($rd_url != ""){
                    $redirect = str_replace("{aff_sub}", $click->id, $rd_url);
                }else {
                    $redirect = str_replace("{aff_sub}", $click->id, $redirect);
                }
                $this->go($redirect);
            }else{
                var_dump($click->getErrors());

                echo \Yii::t("tracking","Click Offer Model Save Failed");
            }
        }else{
            $click->type = EntryIndex::CAMP_2_LP;
            $click->toID = $offerIndex->toID;
            if($rd_url != ""){
                $click->clockID = $rd_id;
                $click->clockName = $rd_name;
            }

            $lp = Landingpage::findOne(['id'=>$click->toID]);
            $redirect = $lp->redirectUrl;
            if($click->validate()) {
                $click->save(false);
                $out = [];
                $out['pid'] = $click->id;
                $out["os"] = $click->deviceOS;
                $out["countryCode"] = $click->countryCode;
                $out["brand"] = $click->brandName;
                $out["model"] = $click->modelName;

                if($rd_url != ""){

                    $redirect = $rd_url;

                }
                $this->go($redirect,$out);
            }else{
                var_dump($click->getErrors());
                echo \Yii::t("tracking","Click LP Model Save Failed");
            }
        }


    }

    public function  go($location,$out=null){
        $arr = parse_url($location);


        if($out){

            if(isset($arr["query"])){
                $location = $location."&".Yii::$app->request->queryString;
            }else{
                $location = $location."?".Yii::$app->request->queryString;
            }

	        $location = $location."&out=".base64_encode(json_encode($out));
        }
      


        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $location");


    }


    function randOffer(&$offers) {
        mt_rand(1,100);
        $roll = mt_rand(1,100);

        $_tmpW = 0;
        $out = null;

        foreach ( $offers as $offer ) {
            $min = $_tmpW;
            $_tmpW += $offer->weight;
            $max = $_tmpW;
            if ($roll > $min && $roll <= $max) {
                $out = $offer;
                break;
            }
        }
        return $offer;
    }

}
