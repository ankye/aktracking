<?php

namespace backend\controllers;

use backend\models\Campaign;
use backend\models\EntryIndex;
use backend\models\Landingpage;
use backend\models\Offer;
use Codeception\Module\Cli;
use Yii;
use backend\models\Click;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * DashboardController implements the CRUD actions for Click model.
 */
class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Click models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Click::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function calcModel(&$model)
    {
        $model['cost'] = sprintf("%.3f",$model['cost']);
        $model['cpc'] = sprintf("%.3f",$model['cost']/$model['click']);
        $model['net'] = $model['income'] - $model['cost'];
        $model['epc'] = sprintf("%.3f",$model['income']/$model['click']);
        $model['roi'] = ($model['income'] - $model['cost'])  /$model['cost'];
        $model['cr'] = $model['lead']/$model['click'];
    }
    protected  function doParams()
    {
        $obj = Yii::$app->request->cookies->get("range");
        $range = "last7";
        if($obj){
            $range = $obj->value;
        }

        //process data range

        if($range == "today"){
            $startTime = date('Y/m/d')." 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "yesterday"){
            $startTime = date('Y/m/d', strtotime("-1 day"))." 00:00:00";
            $endTime = date('Y/m/d')." 00:00:00";
        }else if($range == "last7"){
            $startTime = date('Y/m/d', strtotime("-1 week"))." 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "last14"){
            $startTime = date('Y/m/d', strtotime("-2 week"))." 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "last30"){
            $startTime = date('Y/m/d', strtotime("-30 day"))." 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "thismonth"){
            $startTime = date('Y/m', strtotime("+0 day"))."/01 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "lastmonth"){
            $startTime = date('Y/m', strtotime("-1 month"))."/01 00:00:00";
            $endTime = date('Y/m', strtotime("+0 day"))."/01 00:00:00";
        }else if($range == "thisyear"){
            $startTime = date('Y', strtotime("+0 day"))."/01/01 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else if($range == "lastyear"){
            $startTime = date('Y', strtotime("-1 year"))."/01/01 00:00:00";
            $endTime = date('Y', strtotime("+0 day"))."/01/01 00:00:00";
        }else if($range == "alltime"){
            $startTime = date('Y/m/d', strtotime("-5 year"))." 00:00:00";
            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
        }else{
            $startTime = date('Y/m/d')." 00:00:00";
            $obj = Yii::$app->request->cookies->get("startTime");
            if($obj){
                $startTime = date("Y/m/d H:i:s",$obj->value);
            }

            $endTime = date('Y/m/d', strtotime("+1 day"))." 00:00:00";
            $obj = Yii::$app->request->cookies->get("endTime");
            if($obj){
                $endTime = date("Y/m/d H:i:s",$obj->value);
            }
        }

        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);

        $lpoffer = 1;
        $obj = Yii::$app->request->cookies->get("lpoffer");
        if($obj){
            $lpoffer =$obj->value;
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


    /**
     *
     */
    public function actionOverview()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];
        $lpoffer = $inParams[3];
        $range =  $inParams[2];
        $graph = [];
        if($lpoffer == 2 || $lpoffer == 3) {
            $graph = Click::getGraph($startTime, $endTime);
        }
        $campaignResult = Click::getCampaigns($startTime,$endTime);
        $result = [];
        $cost = 0;
        $income = 0;
        foreach($campaignResult as &$model){
            $this->calcModel($model);
            $campaign = Campaign::findOne(['id'=>$model['campaignID']]);
            $model['name'] = $campaign->name;
            $model['type'] = 0;
            $model['source'] = $campaign->sourceID;
            $model['toID'] = '-';
            $cost += $model['cost'];
            $income += $model['income'];
            $result[] = $model;
            if($lpoffer == 1 || $lpoffer == 3) {
                $offerResult = Click::getOffers($model['campaignID'], $startTime, $endTime);


                foreach ($offerResult as &$submodel) {
                    $this->calcModel($submodel);
                    if ($submodel['type'] == EntryIndex::CAMP_2_OFFER) {
                        $offer = Offer::findOne(['id' => $submodel['toID']]);
                    } else {
                        $offer = Landingpage::findOne(['id' => $submodel['toID']]);
                    }
                    $submodel['campaignID'] = '-';
                    $submodel['source'] = '-';
                    $submodel['name'] = $offer->name;


                    $result[] = $submodel;
                }
            }
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,

        ]);




        return $this->render('overview', [
            'dataProvider' => $dataProvider,
            'startTime'=>date("Y/m/d H:i:s",$startTime),
            'endTime'=>date("Y/m/d H:i:s",$endTime),
            'lpoffer'=>$lpoffer,
            'cost'=>$cost,
            'income'=>$income,
            'range'=>$range,
            'graph'=>$graph,
        ]);
    }

    /**
     *
     */
    public function actionAnalyze()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];

        $lpoffer = $inParams[3];
        $range =  $inParams[2];

        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = Yii::$app->request->post("campaignID");

        }

        $graph = [];

        if(isset($campaignID)){

            if($lpoffer == 2 || $lpoffer == 3) {
                $graph = Click::getCampaignGraph($campaignID,$startTime,$endTime);
            }
            $campaignResult = Click::getCampaign($campaignID,$startTime,$endTime);
            $result = [];
            $cost = 0;
            $income = 0;
            foreach($campaignResult as &$model){
                $this->calcModel($model);
                $campaign = Campaign::findOne(['id'=>$model['campaignID']]);
                $model['name'] = $campaign->name;
                $model['type'] = 0;
                $model['source'] = $campaign->sourceID;
                $model['toID'] = '-';
                $cost += $model['cost'];
                $income += $model['income'];
                $result[] = $model;
                if($lpoffer == 1 || $lpoffer == 3) {
                    $offerResult = Click::getOffers($model['campaignID'], $startTime, $endTime);


                    foreach ($offerResult as &$submodel) {
                        $this->calcModel($submodel);
                        if ($submodel['type'] == EntryIndex::CAMP_2_OFFER) {
                            $offer = Offer::findOne(['id' => $submodel['toID']]);
                        } else {
                            $offer = Landingpage::findOne(['id' => $submodel['toID']]);
                        }
                        $submodel['campaignID'] = '-';
                        $submodel['source'] = '-';
                        $submodel['name'] = $offer->name;


                        $result[] = $submodel;
                    }
                }
            }

        }else{
            $result = [];
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,

        ]);

        return $this->render('analyze', [
            'dataProvider' => $dataProvider,
            'startTime'=>date("Y/m/d H:i:s",$startTime),
            'endTime'=>date("Y/m/d H:i:s",$endTime),
            'graph'=>$graph,
            'range'=>$range,
            'sourceID'=>$sourceID,
            'lpoffer'=>$lpoffer,
            'campaignID'=>isset($campaignID)?$campaignID:'',
        ]);


    }


    /**
     *
     */
    public function actionDayparting()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];

        $range =  $inParams[2];

        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = Yii::$app->request->post("campaignID");

        }

        $graph = [];

        if(isset($campaignID)){
            $graph = Click::getCampaignDayGraph($campaignID,$startTime,$endTime);

            $dayResult = Click::getDayparting($campaignID,$startTime,$endTime);

        }else{
            $dayResult = [];
        }

        $result = [];
        if($dayResult) {
            foreach ($dayResult as &$model) {
                $this->calcModel($model);
                $result[] = $model;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,

        ]);

        return $this->render('dayparting', [
            'dataProvider' => $dataProvider,
            'startTime'=>date("Y/m/d H:i:s",$startTime),
            'endTime'=>date("Y/m/d H:i:s",$endTime),
            'graph'=>$graph,
            'range'=>$range,
            'sourceID'=>$sourceID,
            'campaignID'=>isset($campaignID)?$campaignID:'',
        ]);
    }

    /**
     *
     */
    public function actionWeekparting()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];

        $range =  $inParams[2];

        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = Yii::$app->request->post("campaignID");

        }
        $graph = [];
        if(isset($campaignID)){
            $graph = Click::getCampaignWeekGraph($campaignID,$startTime,$endTime);

            $dayResult = Click::getWeekparting($campaignID,$startTime,$endTime);

        }else{
            $dayResult = [];
        }

        $result = [];
        if($dayResult) {
            foreach ($dayResult as &$model) {
                $this->calcModel($model);
                $result[] = $model;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,

        ]);

        return $this->render('weekparting', [
            'dataProvider' => $dataProvider,
            'startTime'=>date("Y/m/d H:i:s",$startTime),
            'endTime'=>date("Y/m/d H:i:s",$endTime),
            'graph'=>$graph,
            'range'=>$range,
            'sourceID'=>$sourceID,
            'campaignID'=>isset($campaignID)?$campaignID:'',
        ]);
    }

    /**
     *
     */
    public function actionGroup()
    {
        $inParams = $this->doParams();
        $startTime = $inParams[0];
        $endTime = $inParams[1];

        $range =  $inParams[2];
        $group = [];
        $sourceID = Yii::$app->request->get("sourceID");
        if(Yii::$app->request->isPost){
            $sourceID = Yii::$app->request->post("sourceID");
            $campaignID = Yii::$app->request->post("campaignID");
            $group = Yii::$app->request->post("group");
        }
        if(isset($campaignID) && count($group)>0){
            $groups = [];
            foreach($group as $g){
                if($g != ''){
                    $groups[] = $g;
                }
            }
            $dayResult = Click::getGroup($groups,$campaignID,$startTime,$endTime);

        }else{
            $dayResult = [];
        }

        $result = [];
        if($dayResult) {
            foreach ($dayResult as &$model) {
                $this->calcModel($model);
                $result[] = $model;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $result,

        ]);

        return $this->render('group', [
            'dataProvider' => $dataProvider,
            'startTime'=>date("Y/m/d H:i:s",$startTime),
            'endTime'=>date("Y/m/d H:i:s",$endTime),

            'range'=>$range,
            'sourceID'=>$sourceID,
            'campaignID'=>isset($campaignID)?$campaignID:'',

            'group' => $group,
        ]);
    }
    /**
     * Displays a single Click model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Click model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Click();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Click model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Click model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Click model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Click the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Click::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
