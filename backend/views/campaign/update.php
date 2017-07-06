<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Campaign',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="campaign-update">


    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsOffer'=>$modelsOffer,
        'modelsLp' =>$modelsLp,
        'modelsRedirect'=>$modelsRedirect
    ]) ?>

</div>
