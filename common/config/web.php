<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ],
        'deviceDetect' => [
            'class' => 'common\components\devicedelect\DeviceDetect',
        ],
        'geoipDetect'=>[
            'class' => 'common\components\devicedelect\GeoipDetect',
        ],
        'mobileDetect'=>[
            'class'=>'common\components\devicedelect\MobileDetect',
        ]
    ],
    'as locale' => [
        'class' => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => true
    ],
    'on beforeRequest' => function ($event) {
        Yii::$app->setTimeZone(Yii::$app->keyStorage->get('app.timezone'));
        Yii::$app->name =  Yii::$app->keyStorage->get('app.sitename');
    },
];

//if (YII_DEBUG) {
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
//    ];
//}
//
//if (YII_ENV_DEV) {
//    $config['modules']['gii'] = [
//        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
//    ];
//}


return $config;
