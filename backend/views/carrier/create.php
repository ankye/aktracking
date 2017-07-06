<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Carrier */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Carrier',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Carriers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrier-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
