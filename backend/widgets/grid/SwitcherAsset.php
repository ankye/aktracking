<?php
namespace backend\widgets\grid;

class SwitcherAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/widgets/grid/assets/';

    public $js = [

        'switchery/switchery.min.js',
        'layer/layer.js',
        'switchery/modal.js',
    ];

    public $css = [
        'layer/skin/layer.css',
        'switchery/switchery.min.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'kartik\grid\GridViewAsset',
    ];

}