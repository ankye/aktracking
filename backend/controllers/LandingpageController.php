<?php

namespace backend\controllers;

use Yii;
use backend\models\Landingpage;
use backend\models\LandingpageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\EntryIndex;
use backend\models\EntryIndexEx;
use backend\models\Model;
use yii\helpers\ArrayHelper;
/**
 * LandingpageController implements the CRUD actions for Landingpage model.
 */
class LandingpageController extends Controller
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
     * Lists all Landingpage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LandingpageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Landingpage model.
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
     * Creates a new Landingpage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Landingpage();

        $modelsOffer = [new EntryIndex];

        $modelsLp = [new EntryIndexEx];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelsOffer = Model::createMultiple(EntryIndex::classname());
            $modelsLp = Model::createMultiple(EntryIndexEx::classname());

            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
            Model::loadMultiple($modelsLp, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOffer),
                    ActiveForm::validateMultiple($modelsLp),

                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsOffer) && $valid;
            $valid = Model::validateMultiple($modelsLp) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsOffer as $modelOffer) {
                            $modelOffer->fromID = $model->id;
                            $modelOffer->type = EntryIndex::LP_2_OFFER;

                            if (! ($flag = $modelOffer->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsLp as $modelOffer) {
                            $modelOffer->fromID = $model->id;
                            $modelOffer->type = EntryIndex::LP_2_LP;

                            if (! ($flag = $modelOffer->save(false))) {
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

        } else {

            return $this->render('create', [
                'model' => $model,
                'modelsOffer' => (empty($modelsOffer)) ? [new EntryIndex] : $modelsOffer,
                'modelsLp' => (empty($modelsLp)) ? [new EntryIndexEx] : $modelsLp,

            ]);
        }
    }

    /**
     * Updates an existing Landingpage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelsOffer = $model->offers;
        $modelsLp = $model->lps;



        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsOffer, 'id', 'id');
            $oldIDsLp = ArrayHelper::map($modelsLp, 'id', 'id');
            $modelsOffer = Model::createMultiple(EntryIndex::classname(), $modelsOffer);
            $modelsLp = Model::createMultiple(EntryIndexEx::className(),$modelsLp);

            Model::loadMultiple($modelsOffer, Yii::$app->request->post());
            Model::loadMultiple($modelsLp,Yii::$app->request->post());

            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOffer, 'id', 'id')));
            $deletedIDsLp = array_diff($oldIDsLp, array_filter(ArrayHelper::map($modelsLp, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsOffer),
                    ActiveForm::validateMultiple($modelsLp),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();

            $valid = Model::validateMultiple($modelsOffer) && $valid;
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
                            $modelOffer->type = EntryIndex::LP_2_OFFER;
                            if (! ($flag = $modelOffer->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if (! empty($deletedIDsLp)) {
                            EntryIndexEx::deleteAll(['id' => $deletedIDsLp]);
                        }
                        foreach ($modelsLp as $modelOffer) {
                            $modelOffer->fromID = $model->id;
                            $modelOffer->type = EntryIndex::LP_2_LP;
                            if (! ($flag = $modelOffer->save(false))) {
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
        ]);

    }

    /**
     * Deletes an existing Landingpage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        EntryIndex::deleteAll(['fromID' => $id]);


        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Landingpage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Landingpage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Landingpage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
