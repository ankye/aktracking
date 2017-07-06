<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Country */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Country',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
