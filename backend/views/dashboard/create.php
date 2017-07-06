<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Click */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Click',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Clicks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="click-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
