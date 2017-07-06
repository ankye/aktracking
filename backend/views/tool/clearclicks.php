<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\widgets\Pjax;
$this->title = Yii::t('tracking', 'Clear Clicks');
$this->params['breadcrumbs'][] = $this->title;

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

<?php
if($msg != ""){

    ?>
    <div id="myAlert" class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?php echo $msg; ?>
    </div>
<?php } ?>

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
                    'data' => ["today"=>"Today",
                        "yesterday"=>"Yesterday",
                        "last7"=>"Last 7 Days",
                        "last14"=>"Last 14 Days",
                        "last30"=>"Last 30 Days",
                        "thismonth"=>"This Month",
                        "lastmonth"=>"Last Month",
                        "thisyear"=>"This Year",
                        "lastyear"=>"Last Year",
                        "alltime"=>"All Time",],
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
                    url: "'.Url::to(['/dashboard/dayparting']).'?sourceID="+$(this).val(),
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
                <?=Html::submitButton('Clear Clicks',['class'=>'btn btn-primary']);?>

            </div>
        </div>
        <?=Html::endForm();?>
    </div>
</div>