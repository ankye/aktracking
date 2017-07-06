<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Trafficsource */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Trafficsource',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Trafficsources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trafficsource-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
