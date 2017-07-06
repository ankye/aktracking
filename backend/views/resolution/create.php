<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Resolution */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Resolution',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Resolutions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resolution-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
