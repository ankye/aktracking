<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Browserversion */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Browserversion',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Browserversions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="browserversion-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
