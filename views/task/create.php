<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = Yii::t('app', 'Create task');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
