<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Click */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Click',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Clicks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="click-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
