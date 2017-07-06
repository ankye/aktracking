<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Landingpage */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Landingpage',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Landingpages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landingpage-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsOffer'=>$modelsOffer,
        'modelsLp'=>$modelsLp,
    ]) ?>

</div>
