<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Newsletter */

$this->title = Yii::t('app', 'Create newsletter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
