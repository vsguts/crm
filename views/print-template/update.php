<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = Yii::t('app', 'Printing template: {template}', [
    'template' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Printing templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>