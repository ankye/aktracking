<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Brand */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Brand',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
