<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Click */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="click-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'campaignID')->textInput() ?>

    <?php echo $form->field($model, 'type')->textInput() ?>

    <?php echo $form->field($model, 'offerID')->textInput() ?>

    <?php echo $form->field($model, 'lpID')->textInput() ?>

    <?php echo $form->field($model, 'lpClicked')->textInput() ?>

    <?php echo $form->field($model, 'channel')->textInput() ?>

    <?php echo $form->field($model, 'cpc')->textInput() ?>

    <?php echo $form->field($model, 'create_at')->textInput() ?>

    <?php echo $form->field($model, 'conversion_at')->textInput() ?>

    <?php echo $form->field($model, 'isconversion')->textInput() ?>

    <?php echo $form->field($model, 'payout')->textInput() ?>

    <?php echo $form->field($model, 'c1')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c2')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c3')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c4')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c5')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c6')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c7')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c8')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c9')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c10')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c11')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c12')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c13')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c14')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c15')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'c16')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'IP')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'IPINT')->textInput() ?>

    <?php echo $form->field($model, 'countryCode')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'carrierName')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'brandName')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'modelName')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'deviceOS')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'osversion')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'referer')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'refererDomain')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'browser')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'screenResolution')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'screenSize')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'deviceType')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'browserVersion')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'userAgent')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'org')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'isp')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pingbackIP')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'pingbackIPINT')->textInput() ?>

    <?php echo $form->field($model, 'clockID')->textInput() ?>

    <?php echo $form->field($model, 'clockName')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
