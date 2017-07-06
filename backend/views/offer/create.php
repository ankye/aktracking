<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Offer */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Offer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Offers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offer-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
