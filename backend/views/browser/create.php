<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Browser */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Browser',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Browsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="browser-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
