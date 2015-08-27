<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MailingList */

$this->title = Yii::t('app', 'Create mailing list');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mailing lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
