<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Continent */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Continent',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Continents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="continent-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
