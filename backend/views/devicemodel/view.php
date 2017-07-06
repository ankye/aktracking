<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DeviceModel */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Device Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-model-view">

    <p>
        <?php echo Html::a(Yii::t('tracking', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('tracking', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('tracking', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'brandID',
        ],
    ]) ?>

</div>
