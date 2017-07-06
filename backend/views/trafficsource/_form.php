<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Trafficsource */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="trafficsource-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'costType')->dropDownList(\common\helpers\Common::costType()) ?>

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

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
