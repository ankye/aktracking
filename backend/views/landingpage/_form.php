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
/* @var $model backend\models\Landingpage */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="landingpage-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'model-form',
            'id' => 'dynamic-form'
        ]
    ]); ?>

    <?php echo $form->errorSummary($model); ?>


    <?= $form->field($model, "name")->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, "redirectUrl")->textInput(['maxlength' => true])->label("Landing Page Url") ?>

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

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
