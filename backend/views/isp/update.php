<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Isp */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Isp',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Isps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="isp-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
