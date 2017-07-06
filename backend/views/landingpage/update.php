<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Landingpage */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Landingpage',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Landingpages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="landingpage-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsOffer'=>$modelsOffer,
        'modelsLp'=>$modelsLp,
    ]) ?>

</div>
