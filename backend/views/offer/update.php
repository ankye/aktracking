<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Offer */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Offer',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Offers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="offer-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
