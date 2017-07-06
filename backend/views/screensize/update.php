<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ScreenSize */

$this->title = Yii::t('tracking', 'Update {modelClass}: ', [
    'modelClass' => 'Screen Size',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Screen Sizes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tracking', 'Update');
?>
<div class="screen-size-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
