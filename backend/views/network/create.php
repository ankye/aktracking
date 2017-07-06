<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Network */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Network',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Networks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
