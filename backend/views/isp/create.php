<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Isp */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Isp',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Isps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="isp-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
