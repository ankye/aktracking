<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Devicetype */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Devicetype',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Devicetypes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devicetype-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
