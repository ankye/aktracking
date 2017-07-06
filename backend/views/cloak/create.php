<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Cloak */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Cloak',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Cloaks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cloak-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
