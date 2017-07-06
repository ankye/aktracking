<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tracking', 'Campaigns');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Campaign',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'sourceID',
                'enum'=>\backend\models\Trafficsource::dropDownItems(),
            ],
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'type',
                'enum'=>\common\helpers\Common::costType(),
            ],
            [
                'class' => 'backend\widgets\grid\SwitcherColumn',
                'attribute' => 'inactive',
                'filter' => \common\helpers\Common::activeType(),

            ],
            'bid',
            // 'active',
            // 'pingback',
            // 'slug',
            // 'c1',
            // 'c2',
            // 'c3',
            // 'c4',
            // 'c5',
            // 'c6',
            // 'c7',
            // 'c8',
            // 'c9',
            // 'c10',
            // 'c11',
            // 'c12',
            // 'c13',
            // 'c14',
            // 'c15',
            // 'c16',

            ['class' => 'yii\grid\ActionColumn','template'=>"{update} &nbsp;&nbsp; {delete}"],

        ],
    ]); ?>

</div>
