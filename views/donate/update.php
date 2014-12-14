<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Donate */

$this->title = Yii::t('app', 'Donate: {donate}', [
    'donate' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
?>
<div class="donate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
