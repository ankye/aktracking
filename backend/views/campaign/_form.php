<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use backend\widgets\dynamicform\DynamicFormWidget;
use backend\models\Offer;
use backend\modules\Network;
use backend\modules\Trafficsource;
use yii\widgets\Pjax;
use kartik\widgets\SwitchInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */
/* @var $form yii\bootstrap\ActiveForm */


$js = '

 $("#campaign-slug").change(function() {
    slug =  $(this).val(); 
    $.getJSON("'.Url::to('click').'?slug="+slug,{},function(obj){
        $("#campaign-tracking-url").html(obj["tracking-url"]);
    });
 });
        
function onChangeType(i,value){
    
    main =  $("#redirect-"+i+"-redirecttype").val(); 
    $.getJSON("'.Url::to('/admin/index.php?r=campaign/type').'&i="+i+"&main="+main+"&type="+value+"",{},function(obj){
        $("#redirect-"+obj["id"]+"-subtype").html(obj["html"]);
    });
  
}
function onChangeRedirectType(i,value){

  $.getJSON("'.Url::to('/admin/index.php?r=campaign/redirecttype').'&i="+i+"&value="+value+"",{},function(obj){
     $("#redirect-"+obj["id"]+"-type").html(obj["html"]);
     $("#redirect-"+obj["id"]+"-opt").html(obj["opt"]);
  });
   
}

var last_index = $(".redirect").length ;

$(".dynamicform_wrapper_redirect").on("afterInsert", function(e, item) {
     
     $("#redirect-"+last_index+"-redirecttype").change(function(){
        value = $(this).attr("id").split("-");
        index = value[1];
        onChangeRedirectType(index,$(this).val());
    });
    
    $("#redirect-"+last_index+"-type").change(function(){
        value = $(this).attr("id").split("-");
        index = value[1];
        onChangeType(index,$(this).val());
    });
    
    last_index = last_index + 1;
});
';


$this->registerJs($js);


?>

<div class="campaign-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'model-form',
            'id' => 'dynamic-form'
        ]
    ]); ?>


    <?php echo $form->errorSummary($model); ?>

<div class="alert panel-success">
    <div>
        <h4>Base Settings</h4>
    </div>
    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-sm-3">

            <?php
            echo $form->field($model, 'sourceID')->widget(Select2::classname(), [
                'data' => \backend\models\Trafficsource::dropDownItems(),
                'options' => ['placeholder' => 'Select Source'],

                'pluginEvents' => [
                    "change" => 'function() { 
                        
                     }',
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-3">


            <?php
            echo $form->field($model, 'type')->widget(Select2::classname(), [
                'data' => \common\helpers\Common::costType(),
                'options' => ['placeholder' => 'Select a Type'],
                'pluginEvents' => [


                ]
            ]);
            ?>


        </div>
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'bid',['options'=>['class'=>'input-group'],
                'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">$,min{0.001}</span></div>'

            ])->label("Bid.$(cpc/cpm)");
            ?>
        </div>
    </div>

            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>



            <?= \pavlinter\buttons\AjaxButton::widget([

                'options' => [
                    'class' => 'btn btn-success btn-sm',
                ],
                'id' => 'btn-slug-generator',
                'label' => 'Slug Generator',
                'ajaxOptions' => [
                    'beforeSend' => 'function(jqXHR, settings){
                        value = $("#campaign-name").val();
                        var data = [];
                        data.push({name: "name",value: value});
                        settings.data = $.param(data);
            
                    }',
                    'data' => [],
                    'url' => [ Url::to('genslug') ], //default current page
                    'done' => 'function(data){
                        $("#campaign-slug").val(data["slug"]);
                        
                        var p = "";
                        for(i=1;i<=16;i++){
                            param = "c"+i;
                            var value = $("#campaign-"+param).val();
                            if(value != ""){
                                p += param + "=" + value+"&";
                            }
                            p = p.substring(0,p.length-1);
                            
                        }
                       
                        $("#campaign-tracking-url").html(data["tracking-url"] + "?"+p);
                    }',
                ],
            ]);?>

</div>
    <div class="alert panel-info">
        <div>
            <h4>Tracking Params Settings</h4>

            <?= \pavlinter\buttons\AjaxButton::widget([

                'options' => [
                    'class' => 'btn btn-success btn-sm',
                ],
                'id' => 'my-btn',
                'label' => ' Reset Default Params',
                'ajaxOptions' => [
                    'beforeSend' => 'function(jqXHR, settings){
                        value = $("#campaign-sourceid").val();
                        var data = [];
                        data.push({name: "source",value: value});
                        settings.data = $.param(data);
            
                    }',
                    'data' => [],
                    'url' => [ Url::to('paramreset') ], //default current page
                    'done' => 'function(data){
                        for(i=1;i<=16;i++){
                            param = "c"+i;
                            $("#campaign-"+param).val(data[param]);
                        }
                        
                        
                    }',
                ],
            ]);?>

        </div>
        <div class="hr-line-dashed"></div>


        <div class="row">
        <div class="col-sm-3">
            <?php echo $form->field($model, 'c1')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c2')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c3')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c4')->textInput(['maxlength' => true]) ?>

        </div>

    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->field($model, 'c5')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c6')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c7')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c8')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->field($model, 'c9')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c10')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c11')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c12')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->field($model, 'c13')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c14')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-sm-3">
            <?php echo $form->field($model, 'c15')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-sm-3">
            <?php echo $form->field($model, 'c16')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    </div>
    <!-- landingpage end -->



    <div class="alert panel-warning">

        <h4>Pingback Pixel Settings</h4>

        <?php echo $form->field($model, 'pingback')->textInput(['maxlength' => true]) ?>
        {c1},{c2}.....{c16}

    </div>



    <div class="alert panel-danger">

    <h4>
        Active State Settings
    </h4>

    <?php echo $form->field($model, 'inactive')->widget(SwitchInput::className(),[
        "pluginEvents" => [
            "init.bootstrapSwitch" => "function() { console.log(\"init\"); }",
            "switchChange.bootstrapSwitch" => "function() {  }",
        ],
        'pluginOptions' => [
            'size' => 'small',
            'onColor' => 'success',
            'offColor' => 'danger',
        ]
    ])->label("Inactive");?>

        <h4>
            Pass Params
        </h4>

        <?php echo $form->field($model, 'passParams')->widget(SwitchInput::className(),[
            "pluginEvents" => [
                "init.bootstrapSwitch" => "function() { console.log(\"init\"); }",
                "switchChange.bootstrapSwitch" => "function() {  }",
            ],
            'pluginOptions' => [
                'size' => 'small',
                'onColor' => 'success',
                'offColor' => 'danger',
            ]
        ])->label("Pass Params");?>


    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsOffer[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'toID',
            'weight',
            'active',
        ],
    ]); ?>




    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> Offers
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>

            </h4>
        </div>

        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsOffer as $i => $modelOffer): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                            <?php
                            // necessary for update action.
                            if (! $modelOffer->isNewRecord) {
                                echo Html::activeHiddenInput($modelOffer, "[{$i}]id");
                            }
                            ?>



                            <div class="row">
                                <div class="col-sm-8">
                                    <?php
                                    echo $form->field($modelOffer, "[{$i}]toID")->widget(Select2::classname(), [
                                        'data' => \backend\models\Offer::dropDownItems(),
                                    ])->label("Offer Name");
                                    ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($modelOffer, "[{$i}]weight",['options'=>['class'=>'input-group'],
                                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">{0-100}</span></div>'

                                    ] )->label("Split: %") ?>
                                </div>



                                <div class="col-sm-2">
                                    <?php echo $form->field($modelOffer, "[{$i}]inactive")->widget(SwitchInput::className(),[
                                        "pluginEvents" => [
                                            "init.bootstrapSwitch" => "function() { console.log(\"init\"); }",
                                            "switchChange.bootstrapSwitch" => "function() {  }",
                                        ],
                                        'pluginOptions' => [
                                            'size' => 'small',
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ]
                                    ])->label("Inactive");?>
                                </div>

                            </div><!-- .row -->






                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>

    <div class="hr-line-dashed"></div>


    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_lp', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-lp', // required: css class selector
        'widgetItem' => '.lp', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-lp', // css class
        'deleteButton' => '.remove-lp', // css class
        'model' => $modelsLp[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'toID',
            'weight',
            'inactive',
        ],
    ]); ?>




    <div class="panel panel-warning">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> LandingPages
                <button type="button" class="add-lp btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-lp"><!-- widgetBody -->
                <?php foreach ($modelsLp as $i => $modelLp): ?>
                    <div class="lp panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button type="button" class="remove-lp btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>


                            <?php
                            // necessary for update action.
                            if (! $modelLp->isNewRecord) {
                                echo Html::activeHiddenInput($modelLp, "[{$i}]id");
                            }
                            ?>



                            <div class="row">
                                <div class="col-sm-8">
                                    <?php
                                    echo $form->field($modelLp, "[{$i}]toID")->widget(Select2::classname(), [
                                        'data' => \backend\models\Landingpage::dropDownItems(),
                                    ])->label("Landing Page Name");
                                    ?>
                                </div>
                                <div class="col-sm-2">
                                    <?= $form->field($modelLp, "[{$i}]weight",['options'=>['class'=>'input-group'],
                                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">{0-100}</span></div>'
                                    ] )->label("Split: %") ?>
                                </div>

                                <div class="col-sm-2">
                                    <?php echo $form->field($modelLp, "[{$i}]inactive")->widget(SwitchInput::className(),[
                                        "pluginEvents" => [
                                            "init.bootstrapSwitch" => "function() { console.log(\"init\"); }",
                                            "switchChange.bootstrapSwitch" => "function() { alert(\"switchChange\"); }",
                                        ],
                                        'pluginOptions' => [
                                            'size' => 'small',
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ]
                                    ])->label("Inactive");?>
                                </div>
                            </div>





                        </div>
                    </div>


                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>

    <div class="hr-line-dashed"></div>
    <div class="col-sm-offset-10">

        <?php
        echo Html::button('Split Random = ', [ 'class' => 'btn btn-primary ', 'onclick' => '(function ( $event ) { 
            offerTotal = $(".item").length;
            lptotal = $(".lp").length;
            total = offerTotal + lptotal;
            
            if(total>0){
                split = parseInt(100/total);
            }
            for(i=0; i<offerTotal;i++){
                $("#entryindex-"+i+"-weight").val(split);
            }
             for(i=0; i<lptotal;i++){
                $("#entryindexex-"+i+"-weight").val(split);
            }
            if(lptotal>0){
                last = lptotal-1;
                $("#entryindexex-"+last+"-weight").val(split + 100-total*split);
            }else if(offerTotal>0){
                last = offerTotal-1;
                $("#entryindex-"+last+"-weight").val(split + 100-total*split);
            }
         })();' ]);
        ?>
    </div>

    <div class="hr-line-dashed"></div>
<!-- cloak start -->

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_redirect', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-redirects', // required: css class selector
        'widgetItem' => '.redirect', // required: css class
        'limit' => 10, // the maximum times, an element can be added (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-redirect', // css class
        'deleteButton' => '.remove-redirect', // css class
        'model' => $modelsRedirect[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'type',
            'subtype',
            'opt',
            'optValue',
            'priority',
            'redirectUrl',
        ],
    ]); ?>




    <div class="panel panel-info">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-envelope"></i> Redirect & Cloaks
                <button type="button" class="add-redirect btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-redirects"><!-- widgetBody -->
                <?php foreach ($modelsRedirect as $i => $modelRedirect): ?>
                    <div class="redirect panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <div class="pull-right">
                                <button type="button" class="remove-redirect btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                            <?php
                            // necessary for update action.
                            if (! $modelRedirect->isNewRecord) {
                                echo Html::activeHiddenInput($modelRedirect, "[{$i}]id");
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-2">

                                    <?php
                                    echo $form->field($modelRedirect, "[{$i}]redirectType")->widget(Select2::classname(), [
                                        'data' => \common\helpers\Common::redirectType(),
                                        'options' => ['placeholder' => 'Select MainType'],
                                        'pluginEvents' => [
                                            "change" => '
                                                function(){
                                                    onChangeRedirectType('.$i.',$(this).val());
                                            }',
                                        ]
                                    ]);
                                    ?>

                                </div>

                                <div class="col-sm-2">


                                    <?php
                                    echo $form->field($modelRedirect, "[{$i}]opt")->widget(Select2::classname(), [
                                        'data' => \common\helpers\Common::typeOptChoose($modelsRedirect[$i]['redirectType']),
                                        'options' => ['placeholder' => 'Select Opt'],
                                        'pluginEvents' => [
                                            "change" => '
                                                function(){
                                                   // onChangeOptType('.$i.',$(this).val());
                                            }',
                                        ]
                                    ]);
                                    ?>
                                </div>

                                <div class="col-sm-2">


                                    <?php
                                    echo $form->field($modelRedirect, "[{$i}]type")->widget(Select2::classname(), [
                                        'data' => \common\helpers\Common::typeOptionsChoose($modelsRedirect[$i]['redirectType']),
                                        'options' => ['placeholder' => 'Select Type'],
                                        'pluginEvents' => [
                                            "change" => '
                                                function(){
                                                    onChangeType('.$i.',$(this).val());
                                            }',
                                        ]
                                    ]);
                                    ?>

                                </div>
                                <div class="col-sm-4">


                                    <?php
                                    echo $form->field($modelRedirect, "[{$i}]subtype")->widget(Select2::classname(), [
                                        'data' => \common\helpers\Common::subtypeChoose($modelsRedirect[$i]['redirectType'],$modelsRedirect[$i]['type']),
                                        'options' => ['placeholder' => 'Select SubType'],
                                        'pluginEvents' => [
                                            "change" => '
                                                function(){
                                                   // onChangeSubType('.$i.',$(this).val());
                                            }',
                                        ]
                                    ]);
                                    ?>

                                </div>



                                <div class="col-sm-2">
                                    <?= $form->field($modelRedirect, "[{$i}]priority")->textInput(['maxlength' => true]) ?>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <?= $form->field($modelRedirect, "[{$i}]redirectUrl")->textInput(['maxlength' => true]) ?>
                                </div>

                            </div>


                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- .panel -->
    <?php DynamicFormWidget::end(); ?>
    <h3>Tracking URL</h3>
    <div class="well" id="campaign-tracking-url">
        <p>
        <?php
        $post_url = '';
        for($i=1;$i<=16;$i++){
            $key = "c".$i;
            $value = $model->getAttribute($key);
            if($value != ""){
                $post_url .= $key.'='.$value.'&';
            }
        }
        $post_url = rtrim($post_url, '&');



        $url = Url::to('/click/'.$model->slug,true);
        if($post_url != "" ){
            $url = $url."?".$post_url;
        }
        echo $url;
        ?>
        </p>
        <a href="<?php echo $url ?>" >Test</a>
    </div>
    <h3>Landing Page Install</h3>
    <div class="well">
    <?php  echo '
       
        $out = json_decode(base64_decode($_REQUEST["out"]),true);<br/>
        $OFFERURL="http://".$_SERVER["SERVER_NAME"]."/click/index?".$_SERVER["QUERY_STRING"]."&channel=1";
       
        ';
    ?>
    </div>
    <h3>Aff Network Pingback Install</h3>
    <div class="well">
        <?php
            echo   "http://".$_SERVER["SERVER_NAME"]."/pingback/index?aff_sub={aff_sub}";

        ?>
    </div>
    <!-- cloak end -->
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
