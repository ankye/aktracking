<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Useragent */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Useragent',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Useragents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="useragent-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
