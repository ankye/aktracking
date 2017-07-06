<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Continent */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Continent',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Continents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="continent-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
