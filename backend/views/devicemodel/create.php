<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DeviceModel */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Device Model',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Device Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-model-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
