<?php
use yii\helpers\Html;
?>

<?php
if($msg != ""){

    ?>
    <div id="myAlert" class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?php echo $msg; ?>
    </div>
<?php } ?>

<?php

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'database-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>

    <h2>Input mysqli info</h2>
<?=$form->field($model, 'hostname')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'port')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'username')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
<?=$form->field($model, 'database')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'prefix')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>



<div>
    <div class="pull-left">
        <p >
            <span>
                <a href="install.php?r=site/requirement" class="btn btn-lg btn-success">Back</a>
            </span>
        </p>
    </div>
    <div class="pull-right">
        <p >
            <span>

                <?php echo Html::submitButton( Yii::t('install', 'Next') , ['class' => 'btn btn-success btn-lg']) ?>

            </span>
        </p>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>