<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MailingList */

$this->title = __('Create mailing list');
$this->params['breadcrumbs'][] = ['label' => __('Mailing lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-list-create">

    <div class="pull-right buttons-container">
        <?php
            echo Html::submitButton(__('Create'), [
                'form' => 'mailing_list_form',
                'class' => 'btn btn-success',
            ]);
        ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
