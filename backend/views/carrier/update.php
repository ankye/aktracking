<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Carrier */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Carrier',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Carriers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="carrier-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
