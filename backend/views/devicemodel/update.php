<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DeviceModel */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Device Model',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Device Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="device-model-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
