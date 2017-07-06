<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Browserversion */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Browserversion',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Browserversions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="browserversion-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
