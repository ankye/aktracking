<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OSVersion */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Osversion',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Osversions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="osversion-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
