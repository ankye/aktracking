<?php
// Composer
require(__DIR__ . '/../vendor/autoload.php');

// Environment
require(__DIR__ . '/../common/env.php');

// Yii
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../common/config/bootstrap.php');
require(__DIR__ . '/../frontend/config/bootstrap.php');

function checkInstalled()
{
    return file_exists(Yii::getAlias('@base/web/storage/install.txt'));
}


if (!checkInstalled()) {
    header("Location:install.php");
    die;
}


$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../common/config/base.php'),
    require(__DIR__ . '/../common/config/web.php'),
    require(__DIR__ . '/../frontend/config/base.php'),
    require(__DIR__ . '/../frontend/config/web.php')
);


(new yii\web\Application($config))->run();

