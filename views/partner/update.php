<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partner */

$this->title = Yii::t('app', 'Partner: {partner}', [
    'partner' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="partner-update">

    <?php if (!$model->isNewRecord) : ?>
        <div class="pull-right">
            <img src="<?= $model->image->getUrl('80x80') ?>" alt="" />
        </div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'extra' => $extra,
    ]) ?>

</div>
