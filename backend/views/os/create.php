<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\OS */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Os',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
