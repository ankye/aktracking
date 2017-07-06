<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Trafficsource */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Trafficsources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trafficsource-view">

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
            'costType',
            'c1',
            'c2',
            'c3',
            'c4',
            'c5',
            'c6',
            'c7',
            'c8',
            'c9',
            'c10',
            'c11',
            'c12',
            'c13',
            'c14',
            'c15',
            'c16',
        ],
    ]) ?>

</div>
