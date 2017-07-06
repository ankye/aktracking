<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use \yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model backend\models\Cloak */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="cloak-form">


    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'type')->dropDownList(\common\helpers\Common::clockType()) ?>

    <?php echo $form->field($model, 'rule')->textarea(['rows'=>10]) ?>

<?php

//[
//    'onchange'=>'
//            $.pjax.reload({
//            url: "'.Url::to(['/cloak/create']).'?type="+$(this).val(),
//            container: "#pjax-memfeature-form",
//            timeout: 1000,
//            });
//        ',
//
//    'class'=>'form-control',
//    'prompt' => 'Select Type'
//]
// Pjax::begin(['id'=>'pjax-memfeature-form','enablePushState'=>false]);
//
//
//    if($model->type == 1){
//        echo $form->field($model, "rule[from]")->textInput(['maxlength'=>true])->label("From IP");
//        echo $form->field($model, "rule[to]")->textInput(['maxlength'=>true])->label("To IP");
//
//    }
//    if($model->type ==2){
//        echo $form->field($model, "rule[ip]")->textInput(['maxlength'=>true])->label("IP");
//    }
//    if($model->type ==3){
//        echo $form->field($model, "rule[ua]")->textInput(['maxlength'=>true])->label("UserAgent");
//    }
//
 //Pjax::end();
 ?>




    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('tracking', 'Create') : Yii::t('tracking', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
