<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ScreenSize */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Screen Size',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Screen Sizes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="screen-size-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
