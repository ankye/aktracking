<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClickSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="click-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'campaignID') ?>

    <?php echo $form->field($model, 'type') ?>

    <?php echo $form->field($model, 'offerID') ?>

    <?php echo $form->field($model, 'lpID') ?>

    <?php // echo $form->field($model, 'lpClicked') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'cpc') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'conversion_at') ?>

    <?php // echo $form->field($model, 'isconversion') ?>

    <?php // echo $form->field($model, 'payout') ?>

    <?php // echo $form->field($model, 'c1') ?>

    <?php // echo $form->field($model, 'c2') ?>

    <?php // echo $form->field($model, 'c3') ?>

    <?php // echo $form->field($model, 'c4') ?>

    <?php // echo $form->field($model, 'c5') ?>

    <?php // echo $form->field($model, 'c6') ?>

    <?php // echo $form->field($model, 'c7') ?>

    <?php // echo $form->field($model, 'c8') ?>

    <?php // echo $form->field($model, 'c9') ?>

    <?php // echo $form->field($model, 'c10') ?>

    <?php // echo $form->field($model, 'c11') ?>

    <?php // echo $form->field($model, 'c12') ?>

    <?php // echo $form->field($model, 'c13') ?>

    <?php // echo $form->field($model, 'c14') ?>

    <?php // echo $form->field($model, 'c15') ?>

    <?php // echo $form->field($model, 'c16') ?>

    <?php // echo $form->field($model, 'IP') ?>

    <?php // echo $form->field($model, 'IPINT') ?>

    <?php // echo $form->field($model, 'countryCode') ?>

    <?php // echo $form->field($model, 'carrierName') ?>

    <?php // echo $form->field($model, 'brandName') ?>

    <?php // echo $form->field($model, 'modelName') ?>

    <?php // echo $form->field($model, 'deviceOS') ?>

    <?php // echo $form->field($model, 'osversion') ?>

    <?php // echo $form->field($model, 'referer') ?>

    <?php // echo $form->field($model, 'refererDomain') ?>

    <?php // echo $form->field($model, 'browser') ?>

    <?php // echo $form->field($model, 'screenResolution') ?>

    <?php // echo $form->field($model, 'screenSize') ?>

    <?php // echo $form->field($model, 'deviceType') ?>

    <?php // echo $form->field($model, 'browserVersion') ?>

    <?php // echo $form->field($model, 'userAgent') ?>

    <?php // echo $form->field($model, 'org') ?>

    <?php // echo $form->field($model, 'isp') ?>

    <?php // echo $form->field($model, 'pingbackIP') ?>

    <?php // echo $form->field($model, 'pingbackIPINT') ?>

    <?php // echo $form->field($model, 'clockID') ?>

    <?php // echo $form->field($model, 'clockName') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('tracking', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('tracking', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
