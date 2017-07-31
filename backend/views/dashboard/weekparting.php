<?php
/**
 * Created by PhpStorm.
 * User: ankye
 * Date: 2017/6/21
 * Time: 15:32
 */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\widgets\Pjax;

use yii\web\JsExpression;
use daixianceng\echarts\ECharts;

$this->params['breadcrumbs'][] =Yii::t('tracking', 'Week Parting');

?>


<script>


    function chooseRange(select_value) {


        if (select_value == 'today') {
            $('#startTime').val("<?php echo date('Y/m/d'); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");
        }
        if (select_value == 'yesterday') {
            $('#startTime').val("<?php echo date('Y/m/d', strtotime("-1 day")); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d'); ?> 00:00:00");


        }
        if (select_value == 'last7') {
            $('#startTime').val("<?php echo date('Y/m/d', strtotime("-1 week")); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");


        }
        if (select_value == 'last14') {
            $('#startTime').val("<?php echo date('Y/m/d', strtotime("-2 week")); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");


        }
        if (select_value == 'last30') {
            $('#startTime').val("<?php echo date('Y/m/d', strtotime("-30 day")); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");


        }
        if (select_value == 'thismonth') {
            $('#startTime').val("<?php echo date('Y/m', strtotime("+0 day")); ?>/01 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");

        }
        if (select_value == 'lastmonth') {
            $('#startTime').val("<?php echo date('Y/m', strtotime("-1 month")); ?>/01 00:00:00");
            $('#endTime').val("<?php echo date('Y/m', strtotime("+0 day")); ?>/01 00:00:00");


        }
        if (select_value == 'thisyear') {
            $('#startTime').val("<?php echo date('Y', strtotime("+0 day")); ?>/01/01 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");


        }
        if (select_value == 'lastyear') {
            $('#startTime').val("<?php echo date('Y', strtotime("-1 year")); ?>/01/01 00:00:00");
            $('#endTime').val("<?php echo date('Y', strtotime("+0 day")); ?>/01/01 00:00:00");


        }
        if (select_value == 'alltime') {
            $('#startTime').val("<?php echo date('Y/m/d', strtotime("-5 year")); ?> 00:00:00");
            $('#endTime').val("<?php echo date('Y/m/d', strtotime("+1 day")); ?> 00:00:00");

        }
    }

</script>
<div id="main">
    <!-- Panel Other -->
    <div class="alert panel-info">
        <?=Html::beginForm('','post',['class'=>'form']);?>

        <div class="row">

            <div class="col-md-3">
                <?=DateTimePicker::widget([
                    'name' => 'startTime',
                    'id'=>"startTime",
                    'value'=>isset($startTime)?$startTime:'',
                    'options' => ['placeholder' => 'Start DataTime'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd hh:ii:ss',
                        'todayHighlight' => true
                    ]
                ]) ?>
            </div>
            <div class="col-md-3">
                <?=DateTimePicker::widget([
                    'name' => 'endTime',
                    'id'=>'endTime',
                    'value'=>isset($endTime)?$endTime:'',
                    'options' => ['placeholder' => 'End DataTime'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd hh:ii:ss',
                        'todayHighlight' => true
                    ]
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= Select2::widget([

                    'name' => 'range',
                    'value'=> isset($range)?$range:'',
                    'data' => \common\helpers\Common::customDateRange(),
                    'options' => ['placeholder' => 'Date Range'],
                    'pluginEvents' => [
                        "change" => 'function(){
                              chooseRange($(this).val());
                        }',
                    ]
                ]);
                ?>

            </div>
            <div class="col-md-3">


            </div>




        </div>
        <div class="clearfix1"><br/></div>

        <div class="row">
            <div class="col-md-2">
                <?= Select2::widget([

                    'name' => 'sourceID',
                    'value'=> isset($sourceID)?  $sourceID : '',
                    'data' => \backend\models\Trafficsource::dropDownItems(),
                    'options' => ['placeholder' => 'Traffic Srouce'],
                    'pluginEvents' => [
                        "change" => 'function(){
                     $.pjax.reload({
                    url: "'.Url::to(['/dashboard/weekparting']).'&sourceID="+$(this).val(),
                    container: "#pjax-memfeature-form",
                    timeout: 1000,
                    });
                    }',
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-8">

                <?php
                Pjax::begin(['id'=>'pjax-memfeature-form','enablePushState'=>false]);

                $campaigns = [];
                if($sourceID){
                    $campaigns = \backend\models\Campaign::dropDownItems($sourceID);

                }

                echo Select2::widget([
                    'id'=>'campaignID',
                    'name' => 'campaignID',
                    'value'=> isset($campaignID)?  $campaignID : '',
                    'data' => $campaigns,
                    'options' => ['placeholder' => 'Choose Campaign'],

                ]);

                Pjax::end();
                ?>

            </div>
            <div class="col-md-2">
                <?=Html::submitButton('Set Preferences',['class'=>'btn btn-primary']);?>

            </div>
        </div>
        <?=Html::endForm();?>
    </div>
    <?php if(count($graph) > 0 ){

    ?>
    <div class="alert panel-success">


            <?= ECharts::widget([
                'responsive' => true,
                'options' => [
                    'style' => 'height: 250px;'
                ],
                'pluginEvents' => [
                    'click' => [
                        new JsExpression('function (params) {console.log(params)}'),
                        new JsExpression('function (params) {console.log("ok")}')
                    ],
                    'legendselectchanged' => new JsExpression('function (params) {console.log(params.selected)}')
                ],
                'pluginOptions' => [
                    'option' => [
                        'title' => [
                            'text' => 'Lead Graph'
                        ],
                        'tooltip' => [
                            'trigger' => 'axis',
                            'axisPointer'=>['type'=>'cross','label'=>['backgroundColor'=>'#6a7985']],
                        ],
                        'legend' => [
                            'data' => ['click', 'lead', 'cost', 'income', 'profit']
                        ],
                        'grid' => [
                            'left' => '3%',
                            'right' => '3%',
                            'bottom' => '1%',

                            'containLabel' => true
                        ],
                        'toolbox' => [
                            'feature' => [
                                'saveAsImage' => []
                            ]
                        ],
                        'color'=>['#390', '#f8ac59','#d53',  '#1c84c6','#1ab394','#888'],
                        'xAxis' => [

                            'type' => 'category',
                            'axisTick'=>['alignWithLabel'=>true],

                            'data' => $graph['week']
                        ],
                        'yAxis' => [
                            [
                                'type' => 'value',
                                'position' => 'left',
                                'splitLine' => ['show' => false],
                                'splitArea'=> ['show'=>true],
                            ],
                            [
                                'type' => 'value',
                                'position' => 'right',
                                'splitLine' => ['show' => false],
                                'axisLabel' => [
                                    'show' => true,
                                    'formatter' => '${value}',
                                ],
                            ]
                        ],
                        'series' => [
                            [
                                'name' => 'click',
                                'type'=>'line',

                                'label'=>['normal'=>['show'=>true,
                                    'position'=>'top']],
                                'data' => $graph['click']
                            ],
                            [
                                'name' => 'lead',
                                'type' => 'line',


                                'label'=>['normal'=>['show'=>true,
                                    'position'=>'top']],
                                'data' => $graph['lead']
                            ],
                            [
                                'name' => 'cost',
                                'type' => 'bar',
                                'yAxisIndex'=> 1,
                                'barMaxWidth'=>16,

                                'data' => $graph['cost']
                            ],
                            [
                                'name' => 'income',
                                'type' => 'bar',
                                'yAxisIndex'=> 1,
                                'barMaxWidth'=>16,

                                'data' => $graph['income']
                            ],
                            [
                                'name' => 'profit',
                                'type' => 'bar',
                                'yAxisIndex'=> 1,
                                'barMaxWidth'=>16,

                                'label'=>['normal'=>['show'=>true,
                                    'position'=>'top']],

                                'data' =>$graph['profit']
                            ]
                        ]
                    ]
                ]
            ]); ?>

    </div>
    <?php } ?>
    <div class="alert panel-success">

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class'=>"smallTable"],
            'columns' => [

                'week',
                'click',
                'lead',
                [
                    'attribute'=>'epc',
                    'value'=>function($data){
                        return Yii::$app->formatter->asCurrency($data['epc'],'USD',[NumberFormatter::MAX_FRACTION_DIGITS=>3,NumberFormatter::MIN_FRACTION_DIGITS=>3]);
                    }
                ],
                [
                    'attribute'=>'cpc',
                    'value'=>function($data){
                        return Yii::$app->formatter->asCurrency($data['cpc'],'USD',[NumberFormatter::MAX_FRACTION_DIGITS=>3,NumberFormatter::MIN_FRACTION_DIGITS=>3]);
                    }
                ],


                [
                    'attribute'=>'cr',
                    'value'=>function($data){
                        return Yii::$app->formatter->asPercent($data['cr'], 1);
                    }
                ],
                [
                    'attribute'=>'cost',
                    'value'=>function($data){
                        return Yii::$app->formatter->asCurrency($data['cost'],'USD');
                    }
                ],
                [
                    'attribute'=>'income',
                    'value'=>function($data){
                        return Yii::$app->formatter->asCurrency($data['income'],'USD');
                    }
                ],

                [
                    'attribute'=>'net',
                    'header' => 'Profit',
                    'content' => function ($model, $key, $index, $column){
                        $value = $model['net'];
                        $result = \common\helpers\Util::moneyFormat($value); //Yii::$app->formatter->asCurrency($value,'USD');
                        $style = Yii::$app->keyStorage->get("backend.table-profit-color");
                        if($value<0){
                            if($style == 'table_green'){
                                $style = "table_red";
                            }else{
                                $style = "table_green";
                            }

                        }
                        return Html::tag("div",$result,['class'=>$style]);
                    }
                ],

                [
                    'attribute'=>'roi',
                    'header' => 'ROI',
                    'content' => function ($model, $key, $index, $column){
                        $value = $model['roi'];
                        $result =  Yii::$app->formatter->asPercent($value, 1);
                        $style = Yii::$app->keyStorage->get("backend.table-profit-color");
                        if($value<0){
                            if($style == 'table_green'){
                                $style = "table_red";
                            }else{
                                $style = "table_green";
                            }

                        }
                        return Html::tag("div",$result,['class'=>$style]);
                    }
                ],


            ],
        ]); ?>
    </div>
</div>
