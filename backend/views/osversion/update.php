<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OSVersion */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Osversion',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Osversions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="osversion-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
