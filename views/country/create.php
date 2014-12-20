<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = Yii::t('app', 'Create country');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
