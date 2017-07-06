<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Trafficsource */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Trafficsource',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Trafficsources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="trafficsource-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
