<?php

namespace backend\controllers;

use backend\models\DeviceModel;
use backend\models\Devicetype;
use backend\models\RefererDomain;
use backend\models\Resolution;
use backend\models\ScreenSize;
use backend\models\Trafficsource;
use backend\models\Useragent;
use backend\widgets\ActiveForm;
use common\helpers\Common;
use yii\helpers\Url;

use Yii;
use backend\models\Campaign;
use backend\models\CampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Offer;
use backend\models\Cloak;
use backend\models\Carrier;
use backend\models\Country;
use backend\models\OS;
use backend\models\Browser;
use backend\models\Isp;
use backend\models\Org;
use backend\models\Brand;
use backend\models\EntryIndex;
use backend\models\EntryIndexEx;

use backend\models\LpOffer;

use backend\models\Landingpage;
use backend\models\Redirect;

use backend\models\Model;
use yii\helpers\ArrayHelper;
/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller
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

    public function actions()
    {
        return [
            'ajax-update-field' => [
                'class' => 'common\\actions\\AjaxUpdateFieldAction',
                'allowFields' => ['active'],
                'findModel' => [$this, 'findModel']
            ],
            'switcher' => [
                'class' => 'backend\widgets\grid\SwitcherAction'
            ]
        ];
    }


    /**
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Campaign model.
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
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type=null)
    {
        $model = new Campaign();
        $modelsOffer = [new EntryIndex];
        $modelsLp = [new EntryIndexEx];

        $modelsRedirect = [new Redirect];

        if($type){
            $model->type = $type;

        }else if ($model->load(Yii::$app->request->post())) {

            $modelsOffer = Model::createMultiple(EntryIndex::classname());
            $modelsLp = Model::createMultiple(EntryIndexEx::className());
            $modelsRedirect = Model::createMultiple(Redirect::className());

            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
            Model::loadMultiple($modelsLp, Yii::$app->request->post());
            Model::loadMultiple($modelsRedirect,Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOffer),
                    ActiveForm::validateMuliple($modelsLp),
                    ActiveForm::validateMultiple($modelsRedirect),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsOffer) && $valid;
            $valid = Model::validateMultiple($modelsRedirect) && $valid;
            $valid = Model::validateMultiple($modelsLp) && $valid;



            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsOffer as $modelOffer) {
                            $modelOffer->fromID = $model->id;
                            $modelOffer->type = EntryIndex::CAMP_2_OFFER;

                            if (! ($flag = $modelOffer->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsRedirect as $modelRedirect) {
                            $modelRedirect->campaignID = $model->id;
                            if (! ($flag = $modelRedirect->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach($modelsLp as $indexLp => $modelLp){
                            $modelLp->fromID = $model->id;
                            $modelLp->type = EntryIndex::CAMP_2_LP;
                            if( !($flag = $modelLp->save(false))){
                                $transaction->rollBack();
                                break;
                            }

                        }


                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsOffer' => (empty($modelsOffer)) ? [new EntryIndex] : $modelsOffer,
            'modelsRedirect' => (empty($modelsRedirect)) ? [new Redirect] : $modelsRedirect,
            'modelsLp' =>(empty($modelsLp)) ? [new EntryIndexEx] : $modelsLp
        ]);


    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelsOffer = $model->offers;
        $modelsRedirect = $model->redirects;

        $modelsLp = $model->lps;



        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsOffer, 'id', 'id');
            $oldRedirectIDs = ArrayHelper::map($modelsRedirect,'id','id');

            $oldIDsLp = ArrayHelper::map($modelsLp, 'id', 'id');

            $modelsOffer = Model::createMultiple(EntryIndex::classname(), $modelsOffer);
            $modelsRedirect = Model::createMultiple(Redirect::className(),$modelsRedirect);

            $modelsLp = Model::createMultiple(EntryIndexEx::className(),$modelsLp);




            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
            Model::loadMultiple($modelsRedirect,Yii::$app->request->post());

            Model::loadMultiple($modelsLp,Yii::$app->request->post());



            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOffer, 'id', 'id')));
            $deletedIDsRedirect = array_diff($oldRedirectIDs,array_filter(ArrayHelper::map($modelsRedirect,'id','id')));
            $deletedIDsLp = array_diff($oldIDsLp, array_filter(ArrayHelper::map($modelsLp, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOffer),
                    ActiveForm::validateMultiple($modelsRedirect),
                    ActiveForm::validateMultiple($modelsLp),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsOffer) && $valid;

            $valid = Model::validateMultiple($modelsRedirect) && $valid;

            $valid = Model::validateMultiple($modelsLp) && $valid;





            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            EntryIndex::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsOffer as $modelOffer) {
                            $modelOffer->fromID = $model->id;
                            $modelOffer->type = EntryIndex::CAMP_2_OFFER;
                            if (! ($flag = $modelOffer->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if (! empty($deletedIDsRedirect)) {
                            Redirect::deleteAll(['id' => $deletedIDsRedirect]);
                        }
                        foreach ($modelsRedirect as $modelRedirect) {
                            $modelRedirect->campaignID = $model->id;

                            if (! ($flag = $modelRedirect->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }


                        if (! empty($deletedIDsLp)) {
                            EntryIndexEx::deleteAll(['id' => $deletedIDsLp]);
                        }
                        foreach ($modelsLp as $indexLp => $modelLp) {

                            $modelLp->fromID = $model->id;
                            $modelLp->type = EntryIndex::CAMP_2_LP;

                            if (! ($flag = $modelLp->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelsOffer' => (empty($modelsOffer)) ? [new EntryIndex] : $modelsOffer,
            'modelsLp' =>(empty($modelsLp)) ? [new EntryIndexEx] :$modelsLp,
            'modelsRedirect' => (empty($modelsRedirect)) ? [new Redirect] : $modelsRedirect,
        ]);

    }

//    /**
//     * Creates a new Campaign model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate($type=null)
//    {
//        $model = new Campaign();
//        $modelsOffer = [new Offer];
//        $modelsLp = [new Landingpage];
//        $modelsLpOffer = [[new LpOffer]];
//        $modelsRedirect = [new Redirect];
//
//        if($type){
//            $model->type = $type;
//
//        }else if ($model->load(Yii::$app->request->post())) {
//
//            $modelsOffer = Model::createMultiple(Offer::classname());
//            $modelsLp = Model::createMultiple(Landingpage::className());
//            $modelsRedirect = Model::createMultiple(Redirect::className());
//
//            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
//            Model::loadMultiple($modelsLp, Yii::$app->request->post());
//            Model::loadMultiple($modelsRedirect,Yii::$app->request->post());
//
//            // ajax validation
//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelsOffer),
//                    ActiveForm::validateMuliple($modelsLp),
//                    ActiveForm::validateMultiple($modelsRedirect),
//                    ActiveForm::validate($model)
//                );
//            }
//
//            // validate all models
//            $valid = $model->validate();
//            $valid = Model::validateMultiple($modelsOffer) && $valid;
//            $valid = Model::validateMultiple($modelsRedirect) && $valid;
//            $valid = Model::validateMultiple($modelsLp) && $valid;
//
//            if (isset($_POST['LpOffer'][0][0])) {
//                foreach ($_POST['LpOffer'] as $indexLp => $lpoffers) {
//                    foreach ($lpoffers as $indexOffer => $offer) {
//                        $data['LpOffer'] = $offer;
//                        $modelLpOffer = new LpOffer;
//                        $modelLpOffer->load($data);
//                        $modelsLpOffer[$indexLp][$indexOffer] = $modelLpOffer;
//                        $valid = $modelLpOffer->validate() && $valid;
//                    }
//                }
//            }
//
//            if ($valid) {
//                $transaction = \Yii::$app->db->beginTransaction();
//                try {
//                    if ($flag = $model->save(false)) {
//                        foreach ($modelsOffer as $modelOffer) {
//                            $modelOffer->campaignID = $model->id;
//                            if (! ($flag = $modelOffer->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                            }
//                        }
//
//                        foreach ($modelsRedirect as $modelRedirect) {
//                            $modelRedirect->campaignID = $model->id;
//                            if (! ($flag = $modelRedirect->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                            }
//                        }
//
//                        foreach($modelsLp as $indexLp => $modelLp){
//                            $modelLp->campaignID = $model->id;
//                            if( !($flag = $modelLp->save(false))){
//                                $transaction->rollBack();
//                                break;
//                            }
//
//                            if (isset($modelsLpOffer[$indexLp]) && is_array($modelsLpOffer[$indexLp])) {
//                                foreach ($modelsLpOffer[$indexLp] as $indexOffer => $modelOffer) {
//                                    $modelOffer->lpID = $modelLp->id;
//                                    if (!($flag = $modelOffer->save(false))) {
//                                        break;
//                                    }
//                                }
//                            }
//
//                        }
//
//
//                    }
//                    if ($flag) {
//                        $transaction->commit();
//                        return $this->redirect(['view', 'id' => $model->id]);
//                    }
//                } catch (Exception $e) {
//                    $transaction->rollBack();
//                }
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//            'modelsOffer' => (empty($modelsOffer)) ? [new Offer] : $modelsOffer,
//            'modelsRedirect' => (empty($modelsRedirect)) ? [new Redirect] : $modelsRedirect,
//            'modelsLp' =>(empty($modelsLp)) ? [new Landingpage] : $modelsLp,
//            'modelsLpOffer'=>(empty($modelsLpOffer)|| empty($modelsLpOffer[0]))?[[new LpOffer]]:$modelsLpOffer
//        ]);
//
//
//    }
//
//    /**
//     * Updates an existing Campaign model.
//     * If update is successful, the browser will be redirected to the 'view' page.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        $modelsOffer = $model->offers;
//        $modelsRedirect = $model->redirects;
//
//        $modelsLp = $model->lps;
//
//        $modelsLpOffer = [];
//        $oldLpOffers = [];
//
//        if (!empty($modelsLp)) {
//            foreach ($modelsLp as $indexLp => $modelLp) {
//                $lpOffers = $modelLp->offers;
//                $modelsLpOffer[$indexLp] = $lpOffers;
//                $oldLpOffers = ArrayHelper::merge(ArrayHelper::index($lpOffers, 'id'), $oldLpOffers);
//            }
//        }
//
//
//        if ($model->load(Yii::$app->request->post())) {
//
//            $oldIDs = ArrayHelper::map($modelsOffer, 'id', 'id');
//            $oldRedirectIDs = ArrayHelper::map($modelsRedirect,'id','id');
//
//            $oldIDsLp = ArrayHelper::map($modelsLp, 'id', 'id');
//
//            $modelsOffer = Model::createMultiple(Offer::classname(), $modelsOffer);
//            $modelsRedirect = Model::createMultiple(Redirect::className(),$modelsRedirect);
//
//            $modelsLp = Model::createMultiple(Landingpage::className(),$modelsLp);
//
//
//            $lpOffersIDs = [];
//            if (isset($_POST['LpOffer'][0][0])) {
//                foreach ($_POST['LpOffer'] as $indexLp => $lpOffers) {
//                    $lpOffersIDs = ArrayHelper::merge($lpOffersIDs, array_filter(ArrayHelper::getColumn($lpOffers, 'id')));
//                    foreach ($lpOffers as $indexLpOffer => $lpOffer) {
//                        $data['LpOffer'] = $lpOffer;
//                        $modelLpOffer = (isset($lpOffer['id']) && isset($oldLpOffers[$lpOffer['id']])) ? $oldLpOffers[$lpOffer['id']] : new LpOffer;
//                        $modelLpOffer->load($data);
//                        $modelsLpOffer[$indexLp][$indexLpOffer] = $modelLpOffer;
//                        $valid = $modelLpOffer->validate();
//                    }
//                }
//            }
//
//
//            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
//            Model::loadMultiple($modelsRedirect,Yii::$app->request->post());
//
//            Model::loadMultiple($modelsLp,Yii::$app->request->post());
//
//
//
//            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOffer, 'id', 'id')));
//            $deletedIDsRedirect = array_diff($oldRedirectIDs,array_filter(ArrayHelper::map($modelsRedirect,'id','id')));
//            $deletedIDsLp = array_diff($oldIDsLp, array_filter(ArrayHelper::map($modelsLp, 'id', 'id')));
//
//            // ajax validation
//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ArrayHelper::merge(
//                    ActiveForm::validateMultiple($modelsOffer),
//                    ActiveForm::validateMultiple($modelsRedirect),
//                    ActiveForm::validateMultiple($modelsLp),
//                    ActiveForm::validate($model)
//                );
//            }
//
//            // validate all models
//            $valid = $model->validate();
//
//            $valid = Model::validateMultiple($modelsOffer) && $valid;
//
//            $valid = Model::validateMultiple($modelsRedirect) && $valid;
//
//            $valid = Model::validateMultiple($modelsLp) && $valid;
//
//
//
//            $oldLpOffersIDs = ArrayHelper::getColumn($oldLpOffers, 'id');
//            $deletedLpOffersIDs = array_diff($oldLpOffersIDs, $lpOffersIDs);
//
//
//
//            if ($valid) {
//                $transaction = \Yii::$app->db->beginTransaction();
//                try {
//                    if ($flag = $model->save(false)) {
//                        if (! empty($deletedIDs)) {
//                            Offer::deleteAll(['id' => $deletedIDs]);
//                        }
//                        foreach ($modelsOffer as $modelOffer) {
//                            $modelOffer->campaignID = $model->id;
//                            if (! ($flag = $modelOffer->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                            }
//                        }
//
//                        if (! empty($deletedIDsRedirect)) {
//                            Offer::deleteAll(['id' => $deletedIDsRedirect]);
//                        }
//                        foreach ($modelsRedirect as $modelRedirect) {
//                            $modelRedirect->campaignID = $model->id;
//
//                            if (! ($flag = $modelRedirect->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                            }
//                        }
//
//                        if (! empty($deletedLpOffersIDs)) {
//                            Offer::deleteAll(['id' => $deletedLpOffersIDs]);
//                        }
//
//                        if (! empty($deletedIDsLp)) {
//                            Landingpage::deleteAll(['id' => $deletedIDsLp]);
//                        }
//                        foreach ($modelsLp as $indexLp => $modelLp) {
//
//                            if ($flag === false) {
//                                $transaction->rollBack();
//                                break;
//                            }
//
//                            $modelLp->campaignID = $model->id;
//                            if (! ($flag = $modelLp->save(false))) {
//                                $transaction->rollBack();
//                                break;
//                            }
//
//                            if (isset($modelsLpOffer[$indexLp]) && is_array($modelsLpOffer[$indexLp])) {
//                                foreach ($modelsLpOffer[$indexLp] as $indexLpOffer => $modelLpOffer) {
//                                    $modelLpOffer->lpID = $modelLp->id;
//                                    if (!($flag = $modelLpOffer->save(false))) {
//                                        break;
//                                    }
//                                }
//                            }
//
//                        }
//
//                    }
//                    if ($flag) {
//                        $transaction->commit();
//                        return $this->redirect(['view', 'id' => $model->id]);
//                    }
//                } catch (Exception $e) {
//                    $transaction->rollBack();
//                }
//            }
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//            'modelsOffer' => (empty($modelsOffer)) ? [new Offer] : $modelsOffer,
//            'modelsLp' =>(empty($modelsLp)) ? [new Landingpage] :$modelsLp,
//            'modelsLpOffer'=>(empty($modelsLpOffer)|| empty($modelsLpOffer[0]))?[[new LpOffer]]:$modelsLpOffer,
//            'modelsRedirect' => (empty($modelsRedirect)) ? [new Redirect] : $modelsRedirect,
//        ]);
//
//    }

    /**
     * Deletes an existing Campaign model.
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
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *
     * 1=>'Cloak',
     * 2=>'Carrier',
     * 3=>'Browser',
     * 4=>'ISP',
     * 5=>'ORG',
     * 6=>'Country',
     * 7=>'OS',
     * 8=>'Brand',
     * 9=>'Model',
     * 10=>'DeviceType',
     * 11=>'Referer',
     * 12=>'UserAgent',
     * 13=>'Resolution',
     * 14=>'ScreenSize',
    */
    public function actionRedirecttype($i,$value){
         $type = $value;
         $options = Common::typeOptionsChoose($type);
         $opt = Common::typeOptChoose($type);

        $html = "<option value=''>Select Type</option>";
         foreach($options as $key=>$val){
             $html .= "<option value='".$key."'>".$val."</option>";
         }

         $optHtml = "<option value=''>Select Opt</option>";
        foreach($opt as $key=>$val){
            $optHtml .= "<option value='".$key."'>".$val."</option>";
        }
         $result = [];
        $result['type'] = $type;
        $result['id'] = $i;
        $result['html'] = $html;
        $result['opt'] = $optHtml;
        $result['res'] = 0;
        echo json_encode($result);
    }


    public function actionType($i,$main,$type)
    {

        $mainType = $main;
        $options = Common::subtypeChoose($mainType,$type);


        $html = "<option value=''>Select SubType</option>";
        foreach($options as $key=>$val){
            $html .= "<option value='".$key."'>".$val."</option>";
        }

        $result = [];
        $result['type'] = $type;
        $result['id'] = $i;
        $result['html'] = $html;
        $result['res'] = 0;
        echo json_encode($result);
    }

    public function actionParamreset(){
        $sourceID = Yii::$app->request->post("source");
        $result = Trafficsource::findOne($sourceID)->toArray();

        echo json_encode($result);
    }

    public function actionGenslug($slug=null){
        $name = $slug==null ? Yii::$app->request->post("name"):$slug;
        $result = [];
        $result['slug'] = md5($name."|".time());

        $result['tracking-url'] = Url::to('/tracking/'.$result['slug'],true);

        echo json_encode($result);
    }

    public function actionTracking($slug){
        $result = [];
        $campaign = Campaign::findOne(['slug'=>$slug]);
        $post_url = '';
        for($i=1;$i<=16;$i++){
            $key = "c".$i;
            $value = $campaign->getAttribute($key);
            if($value != ""){
                $post_url .= $key.'='.$value.'&';
            }
        }
        $post_url = rtrim($post_url, '&');



        $url = Url::to('/click/'.$slug,true);
        if($post_url != "" ){
            $url = $url."?".$post_url;
        }
        $result['tracking-url'] = $url;

        echo json_encode($result);

    }

}
