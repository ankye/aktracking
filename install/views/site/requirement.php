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
    'id' => 'database-form',
    "options" => [
        "class" => "install-form"
    ]
]);
?>
    <table class="table">
        <caption><h2>Dir/File Permission</h2></caption>
        <thead>
        <tr>
            <th>Dir/File</th>
            <th>Required</th>
            <th>Current</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item[3] ?></td>
                <td><i class="ico-success">&nbsp;</i>R/W</td>
                <td><i class="ico-<?= $item[2] ?>">&nbsp;</i><?= $item[1] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>




<div>
    <div class="pull-left">
        <p >
            <span>
                <a href="install.php?r=site/index" class="btn btn-lg btn-success">Back</a>
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