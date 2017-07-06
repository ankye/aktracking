<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TrafficsourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tracking', 'Trafficsources');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trafficsource-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Trafficsource',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'costType',
                'enum'=>\common\helpers\Common::costType(),
            ],
//            'c1',
//            'c2',
             'c3',
             'c4',
             'c5',
//             'c6',
//             'c7',
//             'c8',
//             'c9',
//             'c10',
            // 'c11',
            // 'c12',
            // 'c13',
            // 'c14',
            // 'c15',
            // 'c16',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
