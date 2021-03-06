<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BrowserversionSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="browserversion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'version') ?>

    <?php echo $form->field($model, 'browserID') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('tracking', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('tracking', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
