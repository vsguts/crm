<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\State */

$this->title = Yii::t('app', 'Create state');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'States'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
