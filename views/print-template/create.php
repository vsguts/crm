<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = Yii::t('app', 'Create template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Printing templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
