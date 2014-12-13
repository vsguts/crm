<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visit */

$this->title = Yii::t('app', 'Visit: {visit}', [
    'visit' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
