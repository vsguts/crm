<?php

use yii\helpers\Html;

$this->title = __('Create partner');
$this->params['breadcrumbs'][] = ['label' => __('Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="partner-create">

    <div class="pull-right buttons-container">
        <?php
            echo Html::submitButton(__('Create'), [
                'form' => 'partner_form',
                'class' => 'btn btn-success',
            ]);
        ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
