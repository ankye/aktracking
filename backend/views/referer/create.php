<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Referer */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Referer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Referers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referer-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
