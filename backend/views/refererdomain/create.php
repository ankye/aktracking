<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RefererDomain */

$this->title = Yii::t('tracking', 'Create {modelClass}', [
    'modelClass' => 'Referer Domain',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('tracking', 'Referer Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referer-domain-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
