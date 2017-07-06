<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClickSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tracking', 'Clicks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="click-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Click',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'campaignID',
            'type',
            'offerID',
            'lpID',
            // 'lpClicked',
            // 'channel',
            // 'cpc',
            // 'create_at',
            // 'conversion_at',
            // 'isconversion',
            // 'payout',
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
            // 'IP',
            // 'IPINT',
            // 'countryCode',
            // 'carrierName',
            // 'brandName',
            // 'modelName',
            // 'deviceOS',
            // 'osversion',
            // 'referer',
            // 'refererDomain',
            // 'browser',
            // 'screenResolution',
            // 'screenSize',
            // 'deviceType',
            // 'browserVersion',
            // 'userAgent',
            // 'org',
            // 'isp',
            // 'pingbackIP',
            // 'pingbackIPINT',
            // 'clockID',
            // 'clockName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
