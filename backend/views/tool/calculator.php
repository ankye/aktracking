<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use yii\widgets\Pjax;
$this->title = Yii::t('tracking', 'Calculator');
$this->params['breadcrumbs'][] = $this->title;

?>

<script type="text/javascript">

    function calcCTR()
    {

        cpm = $("#ctr_cpm").val();
        cr = $("#ctr_cr").val();
        payout = $("#ctr_payout").val();

        result =  (10.0*cpm)/ (payout  * cr);

        $("#ctr_ctr").val(result.toFixed(2));
    }

    function calcCR()
    {

        cpm = $("#cr_cpm").val();
        ctr = $("#cr_ctr").val();
        payout = $("#cr_payout").val();

        result =  (10.0*cpm)/ (payout  * ctr);

        $("#cr_cr").val(result.toFixed(2));
    }

    function calcCPM()
    {

        ctr = $("#cpm_ctr").val();
        cr = $("#cpm_cr").val();
        payout = $("#cpm_payout").val();

        result = payout * 1000.0 * ctr/100.0 * cr/100.0;

        $("#cpm_cpm").val(result.toFixed(3));
    }

</script>


<div id="main">
    <!-- Panel Other -->
    <div class="alert panel-info">
        <?=Html::beginForm('','post',['class'=>'form']);?>

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Payout:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cpm_payout" id="cpm_payout" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CR:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cpm_cr" id="cpm_cr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">


                <div class="form-group">
                    <label class="control-label">CTR:</label>
                    <div>

                        <div class="input-group m-b">
                            <input name="cpm_ctr" id="cpm_ctr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <i class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>

                    </div>
                </div>

            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CPM:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cpm_cpm" id="cpm_cpm" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <button class="btn btn-primary" type="button" onclick="calcCPM()">Calc CPM</button>
                    </div>
                </div>

            </div>
        </div>

        <?=Html::endForm();?>
    </div>

    <div class="alert panel-info">
        <?=Html::beginForm('','post',['class'=>'form']);?>

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Payout:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="ctr_payout" id="ctr_payout" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CR:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="ctr_cr" id="ctr_cr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CPM:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="ctr_cpm" id="ctr_cpm" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <i class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>

                    </div>
                </div>

            </div>

            <div class="col-sm-2">


                <div class="form-group">
                    <label class="control-label">CTR:</label>
                    <div>

                        <div class="input-group m-b">
                            <input name="ctr_ctr" id="ctr_ctr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <button class="btn btn-primary" type="button" onclick="calcCTR()">Calc CTR</button>
                    </div>
                </div>

            </div>
        </div>

        <?=Html::endForm();?>
    </div>

    <div class="alert panel-info">
        <?=Html::beginForm('','post',['class'=>'form']);?>

        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Payout:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cr_payout" id="cr_payout" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CPM:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cr_cpm" id="cr_cpm" type="text" class="form-control"> <span class="input-group-addon">$</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">


                <div class="form-group">
                    <label class="control-label">CTR:</label>
                    <div>

                        <div class="input-group m-b">
                            <input name="cr_ctr" id="cr_ctr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <i class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>

                    </div>
                </div>

            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">CR:</label>
                    <div>
                        <div class="input-group m-b">
                            <input name="cr_cr" id="cr_cr" type="text" class="form-control"> <span class="input-group-addon">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label"></label>
                    <div>
                        <button class="btn btn-primary" type="button" onclick="calcCR()">Calc CR</button>
                    </div>
                </div>

            </div>
        </div>

        <?=Html::endForm();?>
    </div>
</div>