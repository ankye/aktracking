<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OS */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Os',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="os-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
