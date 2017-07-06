<?php
namespace backend\controllers;

use common\components\keyStorage\FormModel;
use common\helpers\Util;

use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';
        return parent::beforeAction($action);
    }



    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [

                'app.sitename'=>[
                    'label' => Yii::t('backend', 'Site Name'),
                    'type' => FormModel::TYPE_TEXTINPUT,
                ],
                'app.timezone' =>[
                    'label' => Yii::t('backend', 'TimeZone'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => Util::getTimezoneItems(),
                ],

                'frontend.maintenance' => [
                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'disabled' => Yii::t('backend', 'Disabled'),
                        'enabled' => Yii::t('backend', 'Enabled')
                    ]
                ],

                'backend.table-profit-color' => [
                    'label' => Yii::t('backend', 'Profit color table style'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'table_green' => Yii::t('backend', 'Green'),
                        'table_red' => Yii::t('backend', 'Red')
                    ]
                ],

                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-black' => 'skin-black',
                        'skin-blue' => 'skin-blue',
                        'skin-green' => 'skin-green',
                        'skin-purple' => 'skin-purple',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow',
                        'skin-black-light' => 'skin-black-light',
                        'skin-blue-light' => 'skin-blue-light',
                        'skin-green-light' => 'skin-green-light',
                        'skin-purple-light' => 'skin-purple-light',
                        'skin-red-light' => 'skin-red-light',
                        'skin-yellow-light' => 'skin-yellow-light',
                    ]
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX
                ]
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'body' => Yii::t('backend', 'Settings was successfully saved'),
                'options' => ['class' => 'alert alert-success']
            ]);
            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
}
