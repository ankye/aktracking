<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use backend\widgets\dynamicform\DynamicFormWidget;
use backend\models\Offer;
use backend\modules\Network;
use backend\modules\Trafficsource;
use yii\widgets\Pjax;
use kartik\widgets\SwitchInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Offer */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="panel-body">

        <?= $form->field($model, "name")->textInput(['maxlength' => true]) ?>
        <div class="row">
            <div class="col-sm-3">

                <?php
                echo $form->field($model, "networkID")->widget(Select2::classname(), [
                    'data' => \backend\models\Network::dropDownItems(),
                ]);
                ?>
            </div>
            <div class="col-sm-3">
                <?= $form->field($model, "payout",['options'=>['class'=>'input-group'],
                    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">$,min{0.001}</span></div>'

                ]) ?>
            </div>

        </div><!-- .row -->

        <?= $form->field($model, "redirectUrl")->textInput(['maxlength' => true]) ?>




    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
