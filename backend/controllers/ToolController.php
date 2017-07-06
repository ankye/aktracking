<?php

namespace backend\controllers;


use Codeception\Module\Cli;
use Yii;
use backend\models\Click;
use common\helpers\Util;


class ToolController extends \yii\web\Controller
{

    protected  function doParams()
    {
        $startTime = strtotime("-1 week");
        $obj = Yii::$app->request->cookies->get("startTime", strtotime("-1 week"));
        if($obj){
            $startTime = $obj->value;
        }
        $endTime = time();
        $obj = Yii::$app->request->cookies->get("endTime",time());
        if($obj){
            $endTime = $obj->value;
        }
        $lpoffer = 1;
        $obj = Yii::$app->request->cookies->get("lpoffer",1);
        if($obj){
            $lpoffer =$obj->value;
        }
        $range = "last7";
        $obj = Yii::$app->request->cookies->get("range","last7");
        if($obj){
            $range =  $obj->value;
        }


        if(Yii::$app->request->isPost){
            $startTime = strtotime( Yii::$app->request->post("startTime"));
            $endTime = strtotime(Yii::$app->request->post("endTime"));
            $lpoffer = Yii::$app->request->post("lpoffer");
            $range = Yii::$app->request->post("range");
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'startTime',
                'value' => $startTime,
                'expire'=>time()+86400*30
            ]));
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'endTime',
                'value' => $endTime,
                'expire'=>time()+86400*30
            ]));
            if(isset($lpoffer)) {
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'lpoffer',
                    'value' => $lpoffer,
                    'expire' => time() + 86400*30
                ]));
            }
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'range',
                'value' => $range,
                'expire'=>time()+86400*30
            ]));
        }
        return [$startTime,$endTime,$range,$lpoffer];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdatecpc()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];
        $range =  $inParams[2];
        $msg = "";
        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = Yii::$app->request->post("campaignID");
            $cpc = Yii::$app->request->post("cpc");

            if($cpc > 0 && $campaignID > 0){
               $result = Click::updateCpc($campaignID,$cpc,$startTime,$endTime);
               
               if($result>0){
                   $msg = \Yii::t("tracking","Success update ({result}) Clicks with cpc $ {cpc}",['result'=>$result,'cpc'=>$cpc]);

               }
               
            }
        }

        return $this->render('updatecpc',
            ['startTime'=>date("Y/m/d H:i:s",$startTime),
                'endTime'=>date("Y/m/d H:i:s",$endTime),
                'range'=>$range,
                'sourceID'=>$sourceID,
                'msg'=>$msg,
                'campaignID'=>isset($campaignID)?$campaignID:'']);
    }

    public function actionUpdatelead()
    {
        $msg = "";
        if(Yii::$app->request->isPost){
            $subids =  Yii::$app->request->post("subids");
            if($subids){
                $ids = explode("\r\n",$subids);
                if(isset($ids)&& is_array($ids) && count($ids)>0)
                {
                    $count = 0;
                    foreach($ids as $aff_sub){
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {

                            $click = Click::findOne(['id'=>$aff_sub]);
                            $click->conversion_at = date("Y/m/d H:i:s");
                            $click->isconversion = 1;
                            $click->pingbackIP = Util::getIP();
                            $click->pingbackIPINT = ip2long($click->pingbackIP);
                            $pid = $click->pid;
                            if(!$click->save(false)){
                                $count--;
                                $transaction->rollBack();
                            }
                            while($pid > 0){
                                $pClick = Click::findOne(['id'=>$pid]);
                                $pClick->conversion_at = $click->conversion_at;
                                $pClick->isconversion = $click->isconversion;
                                $pClick->pingbackIP = $click->pingbackIP;
                                $pClick->pingbackIPINT = $click->pingbackIPINT;
                                $pClick->payout = $click->payout;
                                $pid = $pClick->pid;
                                if(!$pClick->save(false)){
                                    $count--;
                                    $transaction->rollBack();
                                }
                            }
                            $transaction->commit();

                            $count++;
                        } catch (Exception $e) {
                            $count--;
                            $transaction->rollBack();
                        }
                    }
                    if($count>0){
                        $msg =  \Yii::t("tracking",  "Success Update ({count}) leads",['count'=>$count]);
                    }
                }
            }
        }
        return $this->render('updatelead',[

                'msg'=>$msg,
        ]);
    }

    public function actionCalculator()
    {

        return $this->render('calculator');
    }

    public function actionClearclicks()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];
        $range =  $inParams[2];
        $msg = "";
        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = intval(Yii::$app->request->post("campaignID"));
            if(isset($campaignID) && $campaignID>0 ){
                $result = Click::clearClicks($campaignID,$startTime,$endTime);
                if(isset($result) && $result>0){
                    $msg = "[".date("Y/m/d H:i:s",$startTime)."]-[".date("Y/m/d H:i:s",$startTime)."] <br/> Success Delete (".$result.") Clicks";
                }
            }
        }

        return $this->render('clearclicks',
            ['startTime'=>date("Y/m/d H:i:s",$startTime),
                'endTime'=>date("Y/m/d H:i:s",$endTime),
                'range'=>$range,
                'sourceID'=>$sourceID,
                "msg"=>$msg,
                'campaignID'=>isset($campaignID)?$campaignID:'']);
    }


}
