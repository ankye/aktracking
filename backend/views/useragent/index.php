<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UseragentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tracking', 'Useragents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="useragent-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Useragent',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
