<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Donate */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Donate',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Donates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
