<?php
/**
 * @link      https://github.com/wbraganca/yii2-dynamicform
 * @copyright Copyright (c) 2014 Wanderson Bragança
 * @license   https://github.com/wbraganca/yii2-dynamicform/blob/master/LICENSE
 */

namespace backend\widgets\dynamicform;

/**
 * Asset bundle for dynamicform Widget
 *
 * @author Wanderson Bragança <wanderson.wbc@gmail.com>
 */
class DynamicFormAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@backend/widgets/dynamicform/assets/';

    public $js = [
        'yii2-dynamic-form.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\widgets\ActiveFormAsset',
    ];


}
