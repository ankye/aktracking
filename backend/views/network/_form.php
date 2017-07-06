<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Network */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="network-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'apikey')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'apiurl')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'systemType')->dropDownList(\common\helpers\Common::networkType()) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
