<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MailingList */

$this->title = Yii::t('app', 'Mailing list: {name}', [
    'name' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mailing lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="mailing-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
