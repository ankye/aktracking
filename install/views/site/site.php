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
    'id' => 'default-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'SITE_URL')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>


    <div>
        <div class="pull-left">
            <p >
            <span>
                <a href="install.php?r=site/db" class="btn btn-lg btn-success">Back</a>
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