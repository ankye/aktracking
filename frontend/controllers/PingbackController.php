<?php



namespace frontend\controllers;

use backend\models\Click;
use common\helpers\Util;
use backend\models\Campaign;

class PingbackController extends \yii\web\Controller
{
    public function actionIndex($aff_sub)
    {
        $aff_sub = intval($aff_sub);
        if($aff_sub)
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try {

                $click = Click::findOne(['id'=>$aff_sub]);
                $click->conversion_at = date("Y/m/d H:i:s");
                $click->isconversion = 1;
                $click->pingbackIP = Util::getIP();
                $click->pingbackIPINT = ip2long($click->pingbackIP);
                $pid = $click->pid;
                if(!$click->save(false)){
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
                        $transaction->rollBack();
                    }
                }
                $transaction->commit();

                $campaign = Campaign::findOne(['id'=>$click->campaignID]);
                if($campaign && $campaign->pingback != ""){
                    $pingback = $campaign->pingback;
                    for($i=1;$i<=16;$i++){
                        $pingback = str_replace("{c".$i."}",$click->getAttribute('c'.$i),$pingback);
                    }
                    file_get_contents($pingback);
                }
                echo "update success";
            } catch (Exception $e) {
                $transaction->rollBack();
            }




        }


    }

}
