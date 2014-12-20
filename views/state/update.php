<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\State */

$this->title = Yii::t('app', 'State: {state}', [
    'state' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="state-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
