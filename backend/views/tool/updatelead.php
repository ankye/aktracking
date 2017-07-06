<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\widgets\Pjax;
$this->title = Yii::t('tracking', 'Update Lead');
$this->params['breadcrumbs'][] = $this->title;

?>

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
            <div class="form-group col-sm-12 well">
                <label class="col-sm-12 control-label">Input Subids：</label>
                <div class="col-sm-12">
                    <textarea id="subids" rows="15" name="subids" class="form-control"></textarea>
                </div>

            </div>
        </div>

        <div class="row">


            <div class="col-md-10">


            </div>
            <div class="col-md-2">
                <?=Html::submitButton('update',['class'=>'btn btn-primary']);?>

            </div>
        </div>

        <?=Html::endForm();?>
    </div>
</div>