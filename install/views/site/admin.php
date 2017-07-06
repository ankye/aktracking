<?php
use yii\helpers\Html;

if($msg != ""){

    ?>
    <div id="myAlert" class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?php echo $msg; ?>
    </div>
<?php } ?>


<?php

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'admin-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'username')->textInput(['class' => 'form-control'])?>
<?=$form->field($model, 'email')->textInput(['class' => 'form-control'])?>
<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
<?=$form->field($model, 'passwordConfirm')->passwordInput(['class' => 'form-control'])?>


    <div>
        <div class="pull-left">
            <p >
            <span>
                <a href="install.php?r=site/site" class="btn btn-lg btn-success">Back</a>
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