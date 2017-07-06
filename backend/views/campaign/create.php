<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Campaign */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Campaign',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsOffer'=>$modelsOffer,
        'modelsLp' =>$modelsLp,
        'modelsRedirect'=>$modelsRedirect,
    ]) ?>

</div>
