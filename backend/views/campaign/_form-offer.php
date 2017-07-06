<?php

use yii\helpers\Html;
use backend\widgets\dynamicform\DynamicFormWidget;
use kartik\widgets\SwitchInput;
use kartik\select2\Select2;
?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 5,
    'min' => 0,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsLpOffer[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'description'
    ],
]); ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>LPOffers</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span>Add</button>
            </th>
        </tr>
        </thead>
        <tbody class="container-rooms">
        <?php foreach ($modelsLpOffer as $indexLpOffer => $modelLpOffer): ?>
            <tr class="room-item">
                <td class="vcenter">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h4>
                                LpOffer
                            </h4>
                        </div>
                        <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (! $modelLpOffer->isNewRecord) {
                        echo Html::activeHiddenInput($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]id");
                    }
                    ?>


                            <?= $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]name")->textInput(['maxlength' => true]) ?>
                            <div class="row">
                                <div class="col-sm-3">

                                    <?php
                                    echo $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]networkID")->dropDownList(\backend\models\Network::dropDownItems());
                                    ?>
                                </div>
                                <div class="col-sm-3">
                                    <?= $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]payout",['options'=>['class'=>'input-group'],
                                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">$,min{0.001}</span></div>'

                                    ]) ?>
                                </div>
                                <div class="col-sm-6">
                                    <?= $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]weight",['options'=>['class'=>'input-group'],
                                        'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">{0-100}</span></div>'

                                    ] ) ?>
                                </div>
                            </div><!-- .row -->

                            <?= $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]redirectUrl")->textInput(['maxlength' => true]) ?>

                            <?php echo $form->field($modelLpOffer, "[{$indexLp}][{$indexLpOffer}]active")->widget(SwitchInput::className(),[
                                "pluginEvents" => [
                                    "init.bootstrapSwitch" => "function() { console.log(\"init\"); }",
                                    "switchChange.bootstrapSwitch" => "function() { alert(\"switchChange\"); }",
                                ],
                                'pluginOptions' => [
                                    'size' => 'small',
                                    'onColor' => 'success',
                                    'offColor' => 'danger',
                                ]
                            ])->label("");?>



                        </div></div>
                </td>
                <td class="text-center vcenter" style="width: 90px;">
                    <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>