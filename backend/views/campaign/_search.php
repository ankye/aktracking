<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CampaignSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="campaign-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'name') ?>

    <?php echo $form->field($model, 'sourceID') ?>

    <?php echo $form->field($model, 'type') ?>

    <?php echo $form->field($model, 'bid') ?>


    <?php  echo $form->field($model, 'inactive') ?>

    <?php // echo $form->field($model, 'pingback') ?>

    <?php // echo $form->field($model, 'slug') ?>

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

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('tracking', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('tracking', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
